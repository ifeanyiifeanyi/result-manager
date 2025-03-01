<?php

namespace App\Http\Controllers\Student;

use App\Models\Question;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;
use App\Services\ApplicationService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ApplicationSubmitRequest;

class ApplicationController extends Controller
{
    public function __construct(private ApplicationService $applicationService) {}



    public function show()
    {
        // $user = Auth::user();
        $academicSession = AcademicSession::active();
        $user = request()->user();

        if (!$academicSession) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'No active academic session available for applications');
        }

        $application = Application::where('user_id', $user->id)
            ->where('academic_session_id', $academicSession->id)
            ->first();

        if (!$application) {
            // Create a new draft application
            $application = $this->applicationService->createDraftApplication($user, $academicSession);
        }

        $questions = Question::where('academic_session_id', $academicSession->id)->get();

        return view('student.application.show', compact('application', 'questions'));
    }

      /**
     * Submit application form
     *
     * @param ApplicationSubmitRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function submit(ApplicationSubmitRequest $request)
    {
        $user = Auth::user();
        $academicSession = AcademicSession::active();

        if (!$academicSession) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'No active academic session available for applications');
        }

        $application = Application::where('user_id', $user->id)
            ->where('academic_session_id', $academicSession->id)
            ->first();

        if (!$application) {
            return redirect()
                ->route('student.application.show')
                ->with('error', 'Application not found. Please start a new application.');
        }

        // Validate answers against required questions
        $questions = Question::where('academic_session_id', $academicSession->id)
            ->where('is_required', true)
            ->get();

        foreach ($questions as $question) {
            if (!isset($request->answers[$question->id]) || empty($request->answers[$question->id])) {
                return redirect()
                    ->back()
                    ->withInput()
                    ->with('error', "Question '{$question->title}' is required.");
            }
        }

        $this->applicationService->submitApplication($application, $request->answers);

        return redirect()
            ->route('student.application.status')
            ->with('success', 'Application submitted successfully. Please proceed to make payment.');
    }

    /**
     * Check application status
     *
     * @return \Illuminate\View\View
     */
    public function status()
    {
        $user = Auth::user();
        $academicSession = AcademicSession::active();

        if (!$academicSession) {
            return view('student.application.status', ['application' => null]);
        }

        $application = Application::where('user_id', $user->id)
            ->where('academic_session_id', $academicSession->id)
            ->first();

        return view('student.application.status', compact('application'));
    }

    /**
     * Save application as draft
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function saveDraft(Request $request)
    {
        $user = Auth::user();
        $academicSession = AcademicSession::active();

        if (!$academicSession) {
            return redirect()
                ->route('student.dashboard')
                ->with('error', 'No active academic session available for applications');
        }

        $application = Application::where('user_id', $user->id)
            ->where('academic_session_id', $academicSession->id)
            ->first();

        if (!$application) {
            return redirect()
                ->route('student.application.show')
                ->with('error', 'Application not found. Please start a new application.');
        }

        $this->applicationService->saveDraftApplication($application, $request->answers ?? []);

        return redirect()
            ->route('student.application.show')
            ->with('success', 'Application saved as draft');
    }



}
