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
        return $this->belongsTo(User::class);
    }
}
