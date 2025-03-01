<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): \Illuminate\Http\RedirectResponse
    {
        switch ($request->user()->role->name) {
            case 'admin':
                return redirect()->route('admin.dashboard');
                break;
            case 'student':
                return redirect()->route('student.dashboard');
                break;
            default:
                Auth::logout();
                return redirect()->route('login');
                break;
        }
    }
}
