<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Define the relationship with the client
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    // Define the relationship with the shop
    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    // Define the relationship with the driver
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
