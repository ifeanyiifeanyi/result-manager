<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use App\Services\SchoolService;

class GuestLayout extends Component
{
    public $school;

    public function __construct(SchoolService $schoolService)
    {
        $this->school = $schoolService->getSchool();
    }

    public function render(): View
    {
        return view('layouts.guest', [
            'school' => $this->school
        ]);
    }
}
