<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',        // ✅ add this
        'name',
        'email',
        'contact',
        'check_in_date',
        'check_out_date',
        'nights',
    ];

    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class, 'room_id');
    }
}
