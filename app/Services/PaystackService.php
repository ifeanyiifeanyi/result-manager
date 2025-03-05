<?php

namespace App\Services;
use Yabacon\Paystack;

class PaystackService
{
    protected $paystack;

    public function __construct()
    {
        $this->paystack = new Paystack(config('services.paystack.secret_key'));
    }

    
}
