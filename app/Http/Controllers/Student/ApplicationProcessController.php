<?php

namespace App\Http\Controllers\Student;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\StudentProfileService;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\ApplicationSubmitRequest;

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
            ->with('payments')
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

    public function submitApplication(ApplicationSubmitRequest $request)
    {
        DB::beginTransaction();

        try {
            $validatedData = $request->validated();
            $activeSession = AcademicSession::active();


            // Check if application already exists
            $existingApplication = Application::where('user_id', request()->user()->id)
                ->where('academic_session_id', $activeSession->id)
                ->first();

            if ($existingApplication) {
                return redirect()->back()->with('error', 'You have already submitted an application for this session');
            }

             // Create application
             $application = Application::create([
                'user_id' => request()->user()->id,
                'academic_session_id' => $activeSession->id,
                'application_number' => Application::generateApplicationNumber(),
                'status' => Application::STATUS_DRAFT,
                'submitted_at' => now()
            ]);

            // Process and save answers
            foreach ($validatedData['answers'] as $questionId => $answer) {
                $question = Question::findOrFail($questionId);

                // Handle file uploads
                if ($question->type === 'file' && $request->hasFile("answers.{$questionId}")) {
                    $filePath = $request->file("answers.{$questionId}")->store('application_files');
                    $answer = $filePath;
                }

                Answer::create([
                    'application_id' => $application->id,
                    'question_id' => $questionId,
                    'answer' => is_array($answer) ? json_encode($answer) : $answer
                ]);
            }


            DB::commit();
            return redirect()->back()->with('success', 'Application submitted successfully');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

}
