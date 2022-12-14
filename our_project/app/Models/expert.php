<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expert extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'country',
        'city',
        'skills',
        'rate',
        'numRated'
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
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }
    public function chat()
    {
        return $this->hasMany(Chat::class);
    }
}
