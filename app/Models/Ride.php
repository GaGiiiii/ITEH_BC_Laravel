<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ride extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_location',
        'end_location',
        'date',
        'space',
        'user_id'
    ];

    protected function space(): Attribute
    {
        $total = 0;
        $reservations = $this->reservations;

        foreach ($reservations as $reservation) {
            $total += $reservation->space;
        }

        return Attribute::make(
            get: function ($value) use ($total) {
                return $value - $total;
            }
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'ride_id', 'id');
    }
}
