<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    // Define the relationship with orders
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
