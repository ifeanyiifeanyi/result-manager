<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Stevebauman\Location\Facades\Location;

// Updated Intervention Image imports for v3
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class StudentProfileService
{
    /**
     * Get missing required fields for user profile
     *
     * @param User $user
     * @return array
     */
    public function getMissingRequiredFields(User $user): array
    {
        $requiredFields = [
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'phone' => 'Phone Number',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'country' => 'Country',
            'date_of_birth' => 'Date of Birth',
            'gender' => 'Gender',
            'kin_contact_name' => 'Next of Kin Name',
            'kin_contact_phone' => 'Next of Kin Phone'
        ];

        $missingFields = [];

        foreach ($requiredFields as $field => $label) {
            if (empty($user->$field)) {
                $missingFields[$field] = $label;
            }
        }

        return $missingFields;
    }

    /**
     * Update user profile
     *
     * @param User $user
     * @param array $data
     * @return User
     */
    public function updateProfile(User $user, array $data): User
    {
        $user->update($data);
        return $user;
    }

    /**
     * Update user profile photo
     *
     * @param User $user
     * @param UploadedFile $photo
     * @return User
     */
    // public function updateProfilePhoto(User $user, UploadedFile $photo): User
    // {
    //     // Create directory if it doesn't exist
    //     $uploadPath = 'public/uploads/profiles';
    //     if (!Storage::exists($uploadPath)) {
    //         Storage::makeDirectory($uploadPath);
    //     }

    //     // Delete old photo if exists
    //     $oldPhoto = $user->photo;
    //     if ($oldPhoto && $oldPhoto !== 'default-profile.jpg') {
    //         $oldPath = str_replace('storage/', 'public/', $oldPhoto);
    //         if (Storage::exists($oldPath)) {
    //             Storage::delete($oldPath);
    //         }
    //     }

    //     // Process and store new photo
    //     $filename = 'profile_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
    //     $path = 'uploads/profiles/' . $filename;

    //     // Create image manager with GD driver
    //     $manager = new ImageManager(new Driver());

    //     // Read, resize and encode the image using the v3 API
    //     $image = $manager->read($photo->getPathname())
    //         ->resize(300, 300, function ($constraint) {
    //             $constraint->aspectRatio();
    //             $constraint->upsize();
    //         })
    //         ->toJpeg();

    //     // Save the processed image
    //     Storage::put('public/' . $path, $image->toString());

    //     // Update user photo
    //     $user->update([
    //         'photo' => 'storage/' . $path
    //     ]);

    //     return $user;
    // }
    public function updateProfilePhoto(User $user, UploadedFile $photo): User
    {
        // Create directory if it doesn't exist
        $uploadPath = public_path('uploads/profiles');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Delete old photo if exists
        $oldPhoto = $user->photo;
        if ($oldPhoto && $oldPhoto !== 'default-profile.jpg') {
            $oldPath = public_path($oldPhoto);
            if (file_exists($oldPath)) {
                unlink($oldPath);
            }
        }

        // Process and store new photo
        $filename = 'profile_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
        $path = 'uploads/profiles/' . $filename;

        // Create image manager with GD driver
        $manager = new ImageManager(new Driver());

        // Read, resize and encode the image
        $image = $manager->read($photo->getPathname())
            ->resize(300, 300, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->toJpeg();

        // Save directly to public directory
        $image->save(public_path($path));

        // Update user photo without storage prefix
        $user->update([
            'photo' => $path // e.g., 'uploads/profiles/profile_1_123456789.jpg'
        ]);

        return $user;
    }

    /**
     * Get user's active sessions
     *
     * @param User $user
     * @return array
     */
    public function getUserSessions(User $user): array
    {
        $sessions = DB::table('sessions')
            ->where('user_id', $user->id)
            ->orderBy('last_activity', 'desc')
            ->get();

        $formattedSessions = [];

        foreach ($sessions as $session) {
            $locationData = Location::get($session->ip_address);

            // Format the time using Carbon
            $lastActivity = \Carbon\Carbon::createFromTimestamp($session->last_activity);

            $formattedSessions[] = [
                'session_id' => $session->id,
                'ip_address' => $session->ip_address,
                'user_agent' => $session->user_agent,
                'browser' => $this->getBrowserInfo($session->user_agent),
                'location' => $locationData ? $locationData->cityName . ', ' . $locationData->countryName : 'Unknown location',
                'last_activity' => $lastActivity->format('Y-m-d H:i:s'),
                'last_activity_human' => $lastActivity->diffForHumans(),
                'is_current' => session()->getId() === $session->id
            ];
        }

        return $formattedSessions;
    }

    private function getBrowserInfo(?string $userAgent): string
    {
        if (!$userAgent) {
            return 'Unknown';
        }

        if (strpos($userAgent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($userAgent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($userAgent, 'Safari') !== false) {
            return 'Safari';
        } elseif (strpos($userAgent, 'Edge') !== false) {
            return 'Edge';
        } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
            return 'Internet Explorer';
        } else {
            return 'Other';
        }
    }
}
