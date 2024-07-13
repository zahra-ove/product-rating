<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductRating extends Model
{
    use HasFactory;

    public function attribute()
    {
        return $this->belongsTo(ProductAttribute::class);
    }

    public function voter()
    {
        return $this->belongsTo(User::class);
    }
}
