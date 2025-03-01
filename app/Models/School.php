<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    protected $fillable = [
        'name',
        'logo',
        'phone',
        'address',
        'email',
        'description',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'google_map',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'admission_fee',
        'fee_description',
    ];

    public function getAdmissionFeeAttribute($fee)
    {
        return $fee;
    }

    public function getFeeDescriptionAttribute($description)
    {
        return $description;
    }
}
