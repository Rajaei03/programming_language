<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Favorite extends Model
{
    use HasApiTokens,HasFactory, Notifiable;
    protected $fillable = [
        'user_id',
        'experience_id'
    ];
    public function user()
    {
        return $this->belongsTo(user::class);
    }

    public function experience()
    {
        return $this->belongsTo(experience::class);
    }
}
