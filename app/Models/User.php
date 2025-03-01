<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'other_names',
        'username',
        'email',
        'phone',
        'address',
        'address_line_2',
        'city',
        'state',
        'postal_code',
        'country',
        'photo',
        'role_id',
        'password',
        'is_blacklisted',
        'blacklist_reason',
        'date_of_birth',
        'gender',
        'id_number',
        'is_active',
        'last_login_at',
        'last_login_ip',
        'kin_contact_name',
        'kin_contact_phone',
        'kin_contact_relationship',
        'kin_contact_address',
        'last_login_at',
        'last_login_ip'
    ];


    public function role(): BelongsTo{
        return $this->belongsTo(Role::class);
    }

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name . ' ' . ($this->other_names ?? '');
    }

    public function getPhotoAttribute(): string
    {
        if ($this->attributes['photo'] ?? null) {
            return asset($this->attributes['photo']);
        }

        return asset('https://img.freepik.com/free-vector/blue-circle-with-white-user_78370-4707.jpg');
    }


    public function hasRole($role): bool
    {
        return $this->role->name === $role;
    }


    public function getDashboardRoute(): string
    {
        return match($this->role->name) {
            'admin' => 'admin.dashboard',
            'student' => 'student.dashboard',
            default => 'login'
        };
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'is_blacklisted' => 'boolean',
            'date_of_birth' => 'date',
            'gender' => 'string',
            'id_number' => 'string',
            'phone' => 'string',
            'address' => 'string',
            'city' => 'string',
            'state' => 'string',
            'postal_code' => 'string',
            'country' => 'string',
        ];
    }




}
