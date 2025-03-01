<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\AcademicSession;
use App\Services\SessionService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AcademicSessionRequest;
use App\Services\AcademicSessionService;

class AcademicSessionController extends Controller
{
    public function __construct(private AcademicSessionService $sessionService) {}
    public function index()
    {
        $activeSession = AcademicSession::active();
        $sessions = AcademicSession::all();
        return view('admin.academicSession.index', compact('sessions', 'activeSession'));
    }

    public function store(AcademicSessionRequest $request)
    {
        $session = $this->sessionService->createSession($request->validated());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Academic session '{$session->name}' created successfully.",
                'session' => $session
            ]);
        }

        return redirect()->route('admin.academic-sessions')
            ->with('success', "Academic session '{$session->name}' created successfully.");
    }

    public function show(AcademicSession $academicSession)
    {
        return response()->json($academicSession);
    }

   

    public function update(AcademicSessionRequest $request, AcademicSession $academicSession)
    {
        $this->sessionService->updateSession($academicSession, $request->validated());

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "Academic session '{$academicSession->name}' updated successfully.",
                'session' => $academicSession
            ]);
        }

        return redirect()->route('admin.academic-sessions')
            ->with('success', "Academic session '{$academicSession->name}' updated successfully.");
    }


    public function destroy(AcademicSession $academicSession)
    {
        $name = $academicSession->name;
        $this->sessionService->deleteSession($academicSession);

        return to_route('admin.academic-sessions')
            ->with('success', "Academic session '{$name}' deleted successfully.");
    }

    public function toggleActive(AcademicSession $academicSession)
    {
        $this->sessionService->toggleActive($academicSession);

        $status = $academicSession->is_active ? 'activated' : 'deactivated';
        return to_route('admin.academic-sessions')
            ->with('success', "Academic session '{$academicSession->name}' {$status} successfully.");
    }
}
