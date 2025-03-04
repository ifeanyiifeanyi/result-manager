<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $fillable = [
        'user_id',
        'academic_session_id',
        'status',
        'payment_status',
        'application_number',
        'submitted_at',
        'reviewed_at',
        'rejection_reason',
        'application_number',
        'reviewed_at',
        'rejection_reason',
        'submitted_at',
    ];
    protected $casts = [
        'user_id' => 'integer',
        'academic_session_id' => 'integer',
        'submitted_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'payment_status' => 'string',
    ];

    // Possible statuses for the application
    const STATUS_DRAFT = 'draft';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_UNDER_REVIEW = 'under_review';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    // Possible payment statuses
    const PAYMENT_PENDING = 'pending';
    const PAYMENT_PAID = 'paid';
    const PAYMENT_FAILED = 'failed';


    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Scope to get applications that are still pending payment
    public function scopePendingPayment($query)
    {
        return $query->where('payment_status', self::PAYMENT_PENDING);
    }

    // Scope to get applications by status
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Generate a unique application number
    public static function generateApplicationNumber()
    {
        $prefix = 'APP';
        $year = date('Y');
        $random = strtoupper(substr(uniqid(), -6));

        return "{$prefix}-{$year}-{$random}";
    }

    // Scope to get applications that have been paid for
    public function scopePaid($query)
    {
        return $query->where('payment_status', self::PAYMENT_PAID);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class);
    }
}
