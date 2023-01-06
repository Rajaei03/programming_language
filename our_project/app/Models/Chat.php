<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'expert_id'
    ];
    public function expert()
    {
        return $this->belongsTo(expert::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
