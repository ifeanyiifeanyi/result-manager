<?php

namespace App\View\Components;

use Closure;
use Illuminate\View\Component;
use App\Services\SchoolService;
use Illuminate\Contracts\View\View;

class StudentLayout extends Component
{
    public $school;

    /**
     * Create a new component instance.
     */
    public function __construct(SchoolService $schoolService)
    {
        $this->school = $schoolService->getSchool();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = request()->user();
        return view('student.layouts.app', [
            'user' => $user,
            'school' => $this->school
        ]);
    }
}
