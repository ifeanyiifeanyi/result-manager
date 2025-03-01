<?php

namespace App\Services;

use App\Models\User;
use App\Models\Application;
use App\Models\AcademicSession;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ApplicationListRequest;

class ApplicationService
{
    /**
     * Get filtered applications based on request parameters
     *
     * @param ApplicationListRequest $request
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getFilteredApplications(ApplicationListRequest $request)
    {
        $query = Application::with(['user', 'academicSession']);

        // Apply filters
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            })
                ->orWhere('application_number', 'like', "%{$search}%");
        }

        if ($request->has('academic_session_id') && !empty($request->academic_session_id)) {
            $query->where('academic_session_id', $request->academic_session_id);
        }

        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        if ($request->has('payment_status') && !empty($request->payment_status)) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->has('date_from') && !empty($request->date_from)) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && !empty($request->date_to)) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Apply sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortDir = $request->get('sort_dir', 'desc');
        $query->orderBy($sortBy, $sortDir);

        // Paginate results
        return $query->paginate(15);
    }

    /**
     * Create a new draft application for a user
     *
     * @param User $user
     * @param AcademicSession $academicSession
     * @return Application
     */
    public function createDraftApplication(User $user, AcademicSession $academicSession)
    {
        return Application::create([
            'user_id' => $user->id,
            'academic_session_id' => $academicSession->id,
            'status' => Application::STATUS_DRAFT,
            'payment_status' => Application::PAYMENT_PENDING,
            'application_number' => Application::generateApplicationNumber(),
        ]);
    }

    /**
     * Update an application with validated data
     *
     * @param Application $application
     * @param array $data
     * @return Application
     */
    public function updateApplication(Application $application, array $data)
    {
        if (isset($data['status']) && $data['status'] === Application::STATUS_REJECTED && isset($data['rejection_reason'])) {
            $data['reviewed_at'] = now();
        }

        $application->update($data);
        return $application;
    }

    /**
     * Approve an application
     *
     * @param Application $application
     * @return Application
     */
    public function approveApplication(Application $application)
    {
        $application->update([
            'status' => Application::STATUS_APPROVED,
            'reviewed_at' => now(),
        ]);

        // Here you could add logic to send notifications, etc.

        return $application;
    }

    /**
     * Reject an application
     *
     * @param Application $application
     * @param string $rejectionReason
     * @return Application
     */
    public function rejectApplication(Application $application, string $rejectionReason)
    {
        $application->update([
            'status' => Application::STATUS_REJECTED,
            'rejection_reason' => $rejectionReason,
            'reviewed_at' => now(),
        ]);

        // Here you could add logic to send notifications, etc.

        return $application;
    }

    /**
     * Mark an application as under review
     *
     * @param Application $application
     * @return Application
     */
    public function markApplicationUnderReview(Application $application)
    {
        $application->update([
            'status' => Application::STATUS_UNDER_REVIEW,
        ]);

        return $application;
    }

    /**
     * Submit an application
     *
     * @param Application $application
     * @param array $answers
     * @return Application
     */
    public function submitApplication(Application $application, array $answers)
    {
        // Start a transaction
        return DB::transaction(function () use ($application, $answers) {
            // Update application status
            $application->update([
                'status' => Application::STATUS_SUBMITTED,
                'submitted_at' => now(),
            ]);

            // Store answers (this would be implemented when you add the ApplicationAnswer model)
            // $this->storeApplicationAnswers($application, $answers);

            return $application;
        });
    }

    /**
     * Save draft application
     *
     * @param Application $application
     * @param array $answers
     * @return Application
     */
    public function saveDraftApplication(Application $application, array $answers)
    {
        // Start a transaction
        return DB::transaction(function () use ($application, $answers) {
            // Make sure the application is still a draft
            $application->update([
                'status' => Application::STATUS_DRAFT,
            ]);

            // Store answers (this would be implemented when you add the ApplicationAnswer model)
            // $this->storeApplicationAnswers($application, $answers);

            return $application;
        });
    }

    /**
     * Export applications to a CSV file
     *
     * @param ApplicationListRequest $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportApplications(ApplicationListRequest $request)
    {
        $applications = $this->getFilteredApplications($request)->items();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="applications_' . date('Y-m-d') . '.csv"',
        ];

        $columns = [
            'Application Number',
            'Student Name',
            'Email',
            'Phone',
            'Status',
            'Payment Status',
            'Submitted Date',
            'Reviewed Date',
            'Academic Session',
        ];

        $callback = function () use ($applications, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($applications as $application) {
                $row = [
                    $application->application_number,
                    $application->user->full_name,
                    $application->user->email,
                    $application->user->phone,
                    $application->status,
                    $application->payment_status,
                    $application->submitted_at ? $application->submitted_at->format('Y-m-d H:i:s') : 'N/A',
                    $application->reviewed_at ? $application->reviewed_at->format('Y-m-d H:i:s') : 'N/A',
                    $application->academicSession->name,
                ];

                fputcsv($file, $row);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Store application answers (to be implemented later)
     *
     * @param Application $application
     * @param array $answers
     * @return void
     */
    /*
    private function storeApplicationAnswers(Application $application, array $answers)
    {
        // Clear previous answers
        $application->answers()->delete();

        // Store new answers
        foreach ($answers as $questionId => $answer) {
            $question = Question::find($questionId);

            if (!$question) {
                continue;
            }

            // Handle file uploads
            if ($question->type === 'file' && request()->hasFile("answers.{$questionId}")) {
                $file = request()->file("answers.{$questionId}");
                $path = $file->store('application_files/' . $application->id, 'public');
                $answer = $path;
            }

            // Handle array values (checkboxes)
            if (is_array($answer)) {
                $answer = json_encode($answer);
            }

            ApplicationAnswer::create([
                'application_id' => $application->id,
                'question_id' => $questionId,
                'answer' => $answer,
            ]);
        }
    }
    */
}
