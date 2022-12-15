<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'sunday',
        'monday',
        'tuesday',
        'wednsday',
        'thursday',
        'friday',
        'saturday'
    ];

    public function expert()
    {
        return $this->hasOne(expert::class);
    }
}
