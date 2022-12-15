<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'from',
        'to'
    ];
    public function expert()
    {
        return $this->belongsTo(expert::class);
    }

}
