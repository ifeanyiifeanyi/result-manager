<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'application_id',
        'reference',
        'amount',
        'status',
        'currency',
        'paid_at',
        'paystack_response',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function paystackResponse(): Attribute
    {
        return new Attribute(
            get: fn () => $this->attributes['paystack_response'],
            set: fn ($value) => $this->attributes['paystack_response'] = json_encode($value),
        );
    }
}
