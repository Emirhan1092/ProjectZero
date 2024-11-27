<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarPart extends Model
{
    use HasFactory;

    protected $table = 'catalog_car_parts';


    protected $primaryKey = 'id';

    public function dataCar()
    {
        return $this->belongsTo(Car::class , 'car_id', 'car_id');
    }

    public function carGroup()
    {
        return $this->belongsTo(CarGroup::class , 'car_id', 'car_id');
    }

    public function carSchema()
    {
        return $this->belongsTo(CarPart::class , 'group_id', 'part_group_id');
    }

}
