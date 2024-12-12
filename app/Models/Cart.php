<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $guarded = ['id'];


    protected $fillable = [
        'added_by_user_name',
        'added_by_user_id',
        'added_by_user_role',
        'customer_id',
        'customer_car_id',
        'car_id',
        'group_id',
        'part_id',
        'img',
        'number',
        'count',
    ];


    public $timestamps = true;
    public function carParts()
    {
        return $this->hasMany(CarPart::class , 'part_id' , 'part_id');
    }

    public function carParts2()
    {
        return $this->hasMany(CarPart::class , 'group_id' , 'group_id');
    }
}
