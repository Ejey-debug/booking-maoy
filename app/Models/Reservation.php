<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id','user_id','name','email','contact','guests',
        'check_in_date','check_out_date','payment_proof',
        'reference_number','payment_mode',
        'addons','total_price','status'
    ];

    protected $casts = [
        'addons' => 'array',
        'total_price' => 'float',
    ];

    public function room()
    {
        return $this->belongsTo(\App\Models\Room::class, 'room_id');
    }
}
