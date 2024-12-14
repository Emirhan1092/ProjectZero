<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'year',
        'brand',
        'model',
        'vehicle_register_plate',
        'color',
        'kilometers',
        'VIN',
        'engine_number',
        'fuel_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, "id", "user_id");
    }

    public function accident()
    {
        return $this->hasMany(Accident::class, "vehicle_id", "id");
    }
}
