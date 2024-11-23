<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;


    protected $table = 'catalog_cars';

    protected $primaryKey = 'id';


    protected $casts = [
        'parameters' => 'array',
    ];


    public function carPart()
    {
        return $this->hasOne(CarPart::class , 'car_id' , 'car_id');
    }

    public function carCatalog()
    {
        return $this->belongsTo(CarCatalog::class , 'catalog_id' , 'catalog_id');
    }
    public function carModel()
    {
        return $this->belongsTo(CarModel::class , 'model_id' , 'model_id');
    }

    public function carGroup()
    {
        return $this->belongsTo(CarGroup::class , 'car_id' , 'car_id');
    }






}


