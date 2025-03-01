<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AcademicSession extends Model
{
    protected $fillable = ['name', 'description', 'year', 'is_active'];

    protected $casts = [
        'year' => 'date',
        'is_active' => 'boolean',
    ];
    public static function active() {
        return self::where('is_active', true)->first();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function applications() {
        return $this->hasMany(Application::class);
    }

}
