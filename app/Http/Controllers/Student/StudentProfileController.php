<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Services\ProfileService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use App\Services\StudentProfileService;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\UpdateStudentProfileRequest;
use App\Http\Requests\UpdateStudentPasswordRequest;

class StudentProfileController extends Controller
{
    protected $profileService;

    public function __construct(StudentProfileService $profileService)
    {
        $this->profileService = $profileService;
        // $this->middleware('auth');
    }

    public function show()
    {
        $user = Auth::user();
        $missingFields = $this->profileService->getMissingRequiredFields($user);
        $sessions = $this->profileService->getUserSessions($user);

        return view('student.profile.index', compact('user', 'missingFields', 'sessions'));
    }



    public function update(UpdateStudentProfileRequest $request)
    {
        $user = Auth::user();
        $this->profileService->updateProfile($user, $request->validated());

        return redirect()->route('student.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(UpdateStudentPasswordRequest $request)
    {
        $user = request()->user();
        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('student.profile.show')
            ->with('success', 'Password updated successfully.');
    }

    public function updatePhoto(Request $request)
    {
        try {
            $request->validate([
                'photo' => 'required|image|max:2048',
            ]);

            $user = Auth::user();
            $this->profileService->updateProfilePhoto($user, $request->file('photo'));

            return response()->json([
                'success' => true,
                'photo' => asset($user->photo)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function logoutSession(Request $request)
    {
        $sessionId = $request->session_id;

        // Delete the session from the database
        DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Device logged out successfully.');
    }
}
