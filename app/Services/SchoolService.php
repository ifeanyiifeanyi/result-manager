<?php

namespace App\Services;

use App\Models\School;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class SchoolService
{
    public function getSchool(): School
    {
        return School::firstOrNew();
    }

     /**
     * Update school information
     *
     * @param array $data
     * @param UploadedFile|null $logo
     * @return School
     */

    public function updateSchool(array $data, ?UploadedFile $logo = null, ?UploadedFile $favicon = null): School
    {
        $school = $this->getSchool();

        // Handle logo upload if provided
        if ($logo) {
            // Delete old logo if exists
            if ($school->logo && Storage::exists('public/' . $school->logo)) {
                Storage::delete('public/' . $school->logo);
            }

            // Store new logo
            $logoPath = $logo->store('school', 'public');
            $data['logo'] = 'storage/' . $logoPath;
        }

        // Handle favicon upload if provided
        if ($favicon) {
            // Delete old favicon if exists
            if ($school->favicon && Storage::exists('public/' . $school->favicon)) {
                Storage::delete('public/' . $school->favicon);
            }

            // Store new favicon
            $faviconPath = $favicon->store('school', 'public');
            $data['favicon'] = 'storage/' . $faviconPath;
        }



        // Update school data
        $school->fill($data);
        $school->save();

        return $school;
    }
}
