<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\StudentProfileService;

class StudentController extends Controller
{
    public function dashboard(StudentProfileService $profileService)
    {
        $user = request()->user();
        $missingFields = $profileService->getMissingRequiredFields($user);
        return view('student.dashboard', compact('user', 'missingFields'));
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
