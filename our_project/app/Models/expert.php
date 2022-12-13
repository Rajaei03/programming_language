<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $fillable = [
        'country',
        'city',
        'skills'
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }

    public function day()
    {
        return $this->belongsTo(day::class);
    }

    public function duration()
    {
        return $this->hasMany(duration::class);
    }

    public function experience()
    {
        return $this->hasMany(experience::class);
    }
}
