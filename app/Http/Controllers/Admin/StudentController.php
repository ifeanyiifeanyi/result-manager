<?php

namespace App\Http\Controllers\Admin;

use view;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AdminStudentService;
use App\Http\Requests\CreateStudentRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\BlacklistStudentRequest;

class StudentController extends Controller
{

    public function __construct(private AdminStudentService $studentService) {}

    /**
     * Display a listing of the students.
     */
    public function index(Request $request)
    {
        $filters = $request->only(['status', 'search']);
        $students = $this->studentService->getAllStudents($filters);

        return view('admin.student.index', compact('students'));
    }

    public function create()
    {
        return view('admin.student.create');
    }
    public function store(CreateStudentRequest $request)
    {
        $this->studentService->createStudent($request->validated());

        return redirect()
            ->route('admin.students')
            ->with('success', 'Student created successfully. Login credentials have been sent to their email.');
    }

    public function show(User $student)
    {
        // Load the activity logs for this student
        $activities = \Spatie\Activitylog\Models\Activity::where(function ($query) use ($student) {
            $query->where('subject_type', get_class($student))
                ->where('subject_id', $student->id);
        })->orWhere(function ($query) use ($student) {
            // Also get activities where this student is the causer
            $query->where('causer_type', get_class($student))
                ->where('causer_id', $student->id);
        })->orderBy('created_at', 'desc')->take(20)->get();

        // Load the student's applications
        $student->load('applications.academicSession');

        return view('admin.student.show', compact('student', 'activities'));
    }

    public function edit(User $student)
    {
        return view('admin.student.edit', compact('student'));
    }

    public function update(UpdateStudentRequest $request, User $student)
    {
        $this->studentService->updateStudent($student, $request->validated());

        return redirect()
            ->route('admin.students.show', $student)
            ->with('success', 'Student updated successfully.');
    }

    public function toggleActive(User $student)
    {
        $student = $this->studentService->toggleActiveStatus($student);
        $status = $student->is_active ? 'activated' : 'deactivated';

        return redirect()
            ->back()
            ->with('success', "Student account has been {$status}.");
    }

    public function toggleBlacklist(BlacklistStudentRequest $request, User $student)
    {
        $isBlacklisting = !$student->is_blacklisted;
        $reason = $isBlacklisting ? $request->blacklist_reason : null;

        $this->studentService->toggleBlacklistStatus($student, $reason);

        $message = $isBlacklisting
            ? 'Student has been blacklisted.'
            : 'Student has been removed from blacklist.';

        return redirect()
            ->back()
            ->with('success', $message);
    }


    public function resetPassword(User $student)
    {
        $this->studentService->resetPassword($student);

        return redirect()
            ->back()
            ->with('success', 'Student password has been reset and sent to their email.');
    }

    /**
     * Send verification email to student
     */
    public function sendVerificationEmail(User $student)
    {
        $success = $this->studentService->sendVerificationEmail($student);

        if ($success) {
            return redirect()
                ->back()
                ->with('success', 'Verification email has been sent to the student.');
        } else {
            return redirect()
                ->back()
                ->with('error', 'Failed to send verification email. Please try again later.');
        }
    }
}
