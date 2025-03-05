<?php

namespace App\View\Components;

use Illuminate\View\View;
use Illuminate\View\Component;
use App\Services\SchoolService;

class AppLayout extends Component
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
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app', [
            'school' => $this->school
        ]);
    }
}
