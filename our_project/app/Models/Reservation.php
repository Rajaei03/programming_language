<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'expert_id',
        'category_id',
        'day',
        'month',
        'year',
        'from'
    ];

    public function category()
    {
        return $this->BelongsTo(Category::class);
    }
    public function expert()
    {
        return $this->BelongsTo(Expert::class);
    }
    public function user()
    {
        return $this->BelongsTo(User::class);
    }
}
