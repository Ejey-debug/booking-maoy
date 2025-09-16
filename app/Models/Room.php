<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image', // ✅ allow saving image path
    ];

    public function reservations()
    {
        return $this->hasMany(\App\Models\Reservation::class, 'room_id');
    }
}
