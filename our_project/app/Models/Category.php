<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];
    public function experience()
    {
        return $this->hasMany(experience::class);
    }
    public function reservation()
    {
        return $this->hasMany(Reservation::class);
    }




}
