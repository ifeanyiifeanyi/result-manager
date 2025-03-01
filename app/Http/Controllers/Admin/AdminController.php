<?php

namespace App\Http\Controllers\Admin;

use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{

     /**
     * Show the dashboard with application statistics
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        $user = request()->user();

        $currentSession = AcademicSession::active();

        if (!$currentSession) {
            return view('admin.applications.dashboard', [
                'stats' => null,
                'noActiveSession' => true
            ]);
        }

        $stats = [
            'total' => Application::where('academic_session_id', $currentSession->id)->count(),
            'draft' => Application::where('academic_session_id', $currentSession->id)
                ->where('status', Application::STATUS_DRAFT)->count(),
            'submitted' => Application::where('academic_session_id', $currentSession->id)
                ->where('status', Application::STATUS_SUBMITTED)->count(),
            'under_review' => Application::where('academic_session_id', $currentSession->id)
                ->where('status', Application::STATUS_UNDER_REVIEW)->count(),
            'approved' => Application::where('academic_session_id', $currentSession->id)
                ->where('status', Application::STATUS_APPROVED)->count(),
            'rejected' => Application::where('academic_session_id', $currentSession->id)
                ->where('status', Application::STATUS_REJECTED)->count(),
            'paid' => Application::where('academic_session_id', $currentSession->id)
                ->where('payment_status', Application::PAYMENT_PAID)->count(),
            'pending_payment' => Application::where('academic_session_id', $currentSession->id)
                ->where('payment_status', Application::PAYMENT_PENDING)->count(),
        ];

        // Get recent applications
        $recentApplications = Application::with(['user', 'academicSession'])
            ->where('academic_session_id', $currentSession->id)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.applications.dashboard', compact('user','stats', 'recentApplications', 'currentSession'));
    }
}
