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

    // Accessor to ensure options is always an array
    public function getOptionsAttribute($value)
    {
        // If value is null or empty string, return an empty array
        if (empty($value)) {
            return [];
        }

        // If it's already an array, return it
        if (is_array($value)) {
            return $value;
        }

        // If it's a JSON string, decode it
        return json_decode($value, true) ?? [];
    }

    // Mutator to ensure options is stored as a JSON string
    public function setOptionsAttribute($value)
    {
        // Ensure it's an array
        $this->attributes['options'] = is_array($value)
            ? json_encode($value)
            : json_encode([]);
    }

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
