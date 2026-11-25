<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoomType extends Model
{
    protected $fillable = [
        'name', 'price_per_night', 'capacity', 'facilities', 'description', 'image'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}