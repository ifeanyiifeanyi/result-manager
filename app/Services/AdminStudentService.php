<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use App\Mail\StudentAccountCreated;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminStudentService
{

    /**
     * Get all students with filters applied
     */
    public function getAllStudents(array $filters = []): LengthAwarePaginator
    {
        $query = User::whereHas('role', function ($q) {
            $q->where('name', 'student');
        });

        // Filter by status
        if (isset($filters['status'])) {
            if ($filters['status'] === 'active') {
                $query->where('is_active', true);
            } elseif ($filters['status'] === 'inactive') {
                $query->where('is_active', false);
            } elseif ($filters['status'] === 'blacklisted') {
                $query->where('is_blacklisted', true);
            }
        }

        // Search functionality
        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(200);
    }


    /**
     * Create a new student
     */
    public function createStudent(array $data): User
    {
        // Generate a random password
        $password = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Get student role
        $studentRole = Role::where('name', 'student')->first();

        // Create the student
        $student = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'other_names' => $data['other_names'] ?? null,
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'gender' => $data['gender'],
            'date_of_birth' => $data['date_of_birth'],
            'id_number' => $data['id_number'] ?? null,
            'address' => $data['address'] ?? null,
            'address_line_2' => $data['address_line_2'] ?? null,
            'city' => $data['city'] ?? null,
            'state' => $data['state'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'country' => $data['country'] ?? null,
            'role_id' => $studentRole->id,
            'password' => Hash::make($password),
            'is_active' => true,
            'username' => $this->generateUsername($data['first_name'], $data['last_name'])
        ]);

        // Send email with login credentials
        try {
            Mail::to($student->email)
                ->send(new StudentAccountCreated($student, $password));
        } catch (\Exception $e) {
            // Log the error and continue
            logger()->error('Failed to send email to student: ' . $e->getMessage());
        }

        return $student;
    }

    /**
     * Update a student
     */
    public function updateStudent(User $student, array $data): User
    {
        $student->update($data);
        return $student;
    }

    /**
     * Toggle student's active status
     */
    public function toggleActiveStatus(User $student): User
    {
        $student->is_active = !$student->is_active;
        $student->save();

        return $student;
    }

    /**
     * Toggle student's blacklist status
     */
    public function toggleBlacklistStatus(User $student, ?string $reason = null): User
    {
        $student->is_blacklisted = !$student->is_blacklisted;

        if ($student->is_blacklisted) {
            $student->blacklist_reason = $reason;
        } else {
            $student->blacklist_reason = null;
        }

        $student->save();

        return $student;
    }

    /**
     * Reset student password
     */
    public function resetPassword(User $student): string
    {
        // Generate a random password
        $password = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Update password
        $student->password = Hash::make($password);
        $student->save();

        // Send email with new credentials
        try {
            Mail::to($student->email)
                ->send(new StudentAccountCreated($student, $password, true));
          
        } catch (\Exception $e) {
            // Log the error and continue
            logger()->error('Failed to send password reset email to student: ' . $e->getMessage());
        }

        return $password;
    }

    /**
     * Generate a unique username based on name
     */
    private function generateUsername(string $firstName, string $lastName): string
    {
        $baseUsername = strtolower(substr($firstName, 0, 1) . $lastName);
        $baseUsername = preg_replace('/[^a-z0-9]/', '', $baseUsername);

        $username = $baseUsername;
        $counter = 1;

        // Check if username exists
        while (User::where('username', $username)->exists()) {
            $username = $baseUsername . $counter;
            $counter++;
        }

        return $username;
    }
}
