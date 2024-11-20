<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarOwner extends Model
{
    use HasFactory;

    protected $table = 'car_owners';

    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'vehicle_id',
        'accident_id',
        'phone_number',
        'email',
        'birth_date',
        'licence_information',
        'address',
        'name',
        'image',
    ];



    public function vehicle():HasMany
    {
        return $this->hasMany(Vehicle::class , 'vehicle_id' , 'id');
    }

    public function accident():HasMany
    {
        return $this->hasMany(Accident::class , 'accident_id' , 'id');
    }

    public function user()
    {
        return   $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
