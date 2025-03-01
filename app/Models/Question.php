<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'academic_session_id',
        'title',
        'type',
        'options',
        'is_required',
        'display_order',
    ];
    protected $casts = [
        'academic_session_id' => 'integer',
        'options' => 'array',
        'is_required' => 'boolean',
        'display_order' => 'integer',
    ];


    // Add this to the Question model
    protected static function boot()
    {
        parent::boot();

        // Default ordering by display_order
        static::addGlobalScope('order', function ($builder) {
            $builder->orderBy('display_order', 'asc');
        });
    }
    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    // public function answers(): HasMany
    // {
    //     return $this->hasMany(Answer::class);
    // }

    // Get answers for a specific application
    public function getAnswerForApplication($applicationId)
    {
        return $this->answers()->where('application_id', $applicationId)->first();
    }
}
