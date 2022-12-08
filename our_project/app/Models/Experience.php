<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;
    protected $fillable = [
        'price'
    ];

    public function category()
    {
        return $this->belongsTo(category::class);
    }

    public function expert()
    {
        return $this->belongsTo(expert::class);
    }

}
