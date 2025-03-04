<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;
use App\Services\StudentProfileService;

class ApplicationProcessController extends Controller
{
    public function showApplicationForm(StudentProfileService $profileService)
    {
        $activeSession = AcademicSession::active();
        $user = request()->user();
        $missingFields = $profileService->getMissingRequiredFields($user);

        if (!$activeSession) {
            return redirect()->back()->with('error', 'No active academic session available for applications');
        }

        //check if student already has an application
        $application = request()->user()->applications()
            ->where('academic_session_id', $activeSession->id)
            ->with('payment')
            ->latest()
            ->first();

        // application questions
        $questions = $activeSession->questions;
        return view('student.application.start', compact(
            'questions',
            'activeSession',
            'application',
            'missingFields',
            'user'
        ));
    }
}
