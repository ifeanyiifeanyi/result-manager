<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Application;
use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        // Find the active academic session with debugging
        $currentSession = AcademicSession::where('is_active', true)->first();

        // If no active session, prepare the view with appropriate messaging
        if (!$currentSession) {
            return view('admin.dashboard', [
                'user' => $user,
                'stats' => null,
                'noActiveSession' => true,
                'sessionError' => 'No active academic session found. Please activate a session.'
            ]);
        }

        // Retrieve statistics with more robust querying
        $stats = [
            'total_users' => User::count(),
            'total' => Application::count(),
            'draft' => Application::whereIn('status', ['draft', 'Draft'])->count(),
            'submitted' => Application::whereIn('status', ['submitted', 'Submitted'])->count(),
            'under_review' => Application::whereIn('status', ['under_review', 'Under Review'])->count(),
            'approved' => Application::whereIn('status', ['approved', 'Approved'])->count(),
            'rejected' => Application::whereIn('status', ['rejected', 'Rejected'])->count(),
            'paid' => Application::whereIn('payment_status', ['paid', 'Paid'])->count(),
            'pending_payment' => Application::whereIn('payment_status', ['pending', 'Pending'])->count(),
        ];

        // Get recent applications with user and session details
        $recentApplications = Application::with(['user', 'academicSession'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('admin.dashboard', [
            'user' => $user,
            'stats' => $stats,
            'recentApplications' => $recentApplications,
            'currentSession' => $currentSession
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
