<?php

namespace App\Http\Controllers\Admin;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;
use App\Services\ApplicationService;
use App\Http\Requests\ApplicationListRequest;

class ApplicationController extends Controller
{
    public function __construct(private ApplicationService $applicationService) {}

    public function index(ApplicationListRequest $request)
    {
        $applications = $this->applicationService->getFilteredApplications($request);
        $academicSessions = AcademicSession::orderBy('name', 'desc')->get();

        return view('admin.application.index', compact('applications', 'academicSessions'));
    }

    public function show(Application $application)
    {
        $application->load(['user', 'academicSession']);

        // Load application answers if they exist
        // $answers = $application->answers()->with('question')->get();

        return view('admin.application.show', compact('application'));
    }

      /**
     * Mark an application for review
     *
     * @param Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function review(Application $application)
    {
        $this->applicationService->markApplicationUnderReview($application);

        return redirect()
            ->route('admin.applications.show', $application)
            ->with('success', 'Application marked as under review');
    }

     /**
     * Approve an application
     *
     * @param Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function approve(Application $application)
    {
        $this->applicationService->approveApplication($application);

        return redirect()
            ->route('admin.applications')
            ->with('success', 'Application has been approved');
    }

    /**
     * Reject an application with reason
     *
     * @param Request $request
     * @param Application $application
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(Request $request, Application $application)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:5',
        ]);

        $this->applicationService->rejectApplication($application, $request->rejection_reason);

        return redirect()
            ->route('admin.applications')
            ->with('success', 'Application has been rejected');
    }

    /**
     * Export applications as CSV
     *
     * @param ApplicationListRequest $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function export(ApplicationListRequest $request)
    {
        return $this->applicationService->exportApplications($request);
    }


}
