<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\StudentProfileService;

class StudentController extends Controller
{
    public function dashboard(StudentProfileService $profileService)
    {
        $user = request()->user();
        $missingFields = $profileService->getMissingRequiredFields($user);
        return view('student.dashboard', compact('user', 'missingFields'));
    }
}
