<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolSettingRequest;
use App\Services\SchoolService;
use Illuminate\Http\Request;

class SchoolController extends Controller
{
    public function __construct(private SchoolService $schoolService) {}


    public function index()
    {
        $school = $this->schoolService->getSchool();
        return view('admin.school-settings.index', compact('school'));
    }

      /**
     * Display the school details
     *
     * @return \Illuminate\View\View
     */
    public function show()
    {
        $school = $this->schoolService->getSchool();
        return view('admin.school-settings.show', compact('school'));
    }

     /**
     * Update school information
     *
     * @param SchoolRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(SchoolSettingRequest $request)
    {
        // Get validated data
        $validatedData = $request->validated();

        // Update school via service
        $this->schoolService->updateSchool(
            $validatedData,
            $request->hasFile('logo') ? $request->file('logo') : null,
            $request->hasFile('favicon') ? $request->file('favicon') : null
        );

        return redirect()
            ->route('admin.school-settings')
            ->with('success', 'School information has been updated successfully');
    }
}
