<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\Image;
use App\Services\SessionService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use App\Services\StudentProfileService;
use Illuminate\Support\Facades\Storage;

use Intervention\Image\Drivers\Gd\Driver;
use App\Http\Requests\AdminProfileUpdateRequest;
use App\Http\Requests\AdminPasswordUpdateRequest;



class AdminProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SessionService $sessionService, StudentProfileService $profileService)
    {
        $user = Auth::user(); // Use auth() helper instead of request()
        $sessions = $sessionService->getUserSessions($user->id);
        $missingFields = $profileService->getMissingRequiredFields($user);

        return view('admin.profile.index', compact('user', 'sessions', 'missingFields'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminProfileUpdateRequest $request)
    {
        // if ($request->validator->fails()) {
        //     return to_route('admin.profile', ['tab' => 'edit'])
        //         ->withErrors($request->validator)
        //         ->withInput();
        // }

        request()->user()->update($request->validated());
        return to_route('admin.profile')->with('success', 'Profile updated successfully');
    }

    /**
     * Update the user's password
     */
    public function updatePassword(AdminPasswordUpdateRequest $request)
    {
        // if ($request->validator->fails()) {
        //     return to_route('admin.profile', ['tab' => 'password'])
        //         ->withErrors($request->validator)
        //         ->withInput();
        // }
        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);
        return to_route('admin.profile')->with('success', 'Password updated successfully');
    }

    /**
     * Process and save the profile photo
     *
     * @param \Illuminate\Http\UploadedFile|null $file
     * @param array $cropData
     * @param int $userId
     * @return string
     */
    public function updatePhoto(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'cropped_data' => ['required', 'json'],
        ]);

        $user = Auth::user();
        $croppedData = json_decode($request->input('cropped_data'), true);

        // Get the raw image from the current src
        $imageData = null;

        // Check if this is a data URL from the cropper
        if (isset($_POST['image_data']) && strpos($_POST['image_data'], 'data:image') === 0) {
            $imageData = $_POST['image_data'];
        }

        // Process and save the image
        $imagePath = $this->processProfilePhoto($imageData, $croppedData, $user->id);

        // Delete old photo if exists
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        // Update user photo
        request()->user()->update([
            'photo' => $imagePath,
        ]);

        return redirect()->route('admin.profile')->with('success', 'Profile photo updated successfully.');
    }

    private function processProfilePhoto($imageData, array $cropData, int $userId): string
    {
        // Initialize ImageManager with driver
        $manager = new ImageManager(new Driver());

        if ($imageData) {
            // For data URLs from the cropper, we need to decode base64
            $imageData = str_replace('data:image/jpeg;base64,', '', $imageData);
            $imageData = str_replace('data:image/png;base64,', '', $imageData);
            $imageData = base64_decode($imageData);
            $croppedImage = $manager->read($imageData);
        } else {
            // If no image data, use existing photo or default
            $user = Auth::user();
            if ($user->photo && file_exists(public_path($user->photo))) {
                $croppedImage = $manager->read(public_path($user->photo));
            } else {
                // Use a placeholder image
                $croppedImage = $manager->read(public_path('no-img.png'));
            }
        }

        // Crop the image
        $croppedImage->crop(
            (int) $cropData['width'],
            (int) $cropData['height'],
            (int) $cropData['x'],
            (int) $cropData['y']
        );

        // Resize to standard size
        $croppedImage->resize(300, 300);

        // Generate a unique filename
        $directory = 'uploads/profile_photos';
        if (!file_exists(public_path($directory))) {
            mkdir(public_path($directory), 0755, true);
        }

        $filename = $directory . '/profile_' . $userId . '_' . time() . '.jpg';
        $fullPath = public_path($filename);

        // Save the file with proper encoding - THIS IS THE FIX
        file_put_contents($fullPath, $croppedImage->toJpeg(80)->toString());

        return $filename; // Return the relative path
    }

    /**
     * Delete the user's profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();

        // Delete photo if exists
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }

        // Update user to remove photo
        request()->user()->update([
            'photo' => null,
        ]);

        return to_route('admin.profile')->with('success', 'Profile photo removed successfully.');
    }

    /**
     * Log the user out of a specific session
     */
    public function logoutSession(Request $request, $sessionId, SessionService $sessionService)
    {
        $sessionService->invalidateSession($sessionId, Auth::id());

        return to_route('admin.profile')->with('success', 'Session logged out successfully.');
    }

    /**
     * Log the user out of all sessions except the current one
     */
    public function logoutAllSessions(SessionService $sessionService)
    {
        $sessionService->invalidateAllSessions(Auth::id(), session()->getId());

        return to_route('admin.profile')->with('success', 'Logged out of all other devices successfully.');
    }
}
