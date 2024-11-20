<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarCatalog extends Model
{
    use HasFactory;


    protected $table = 'catalogs';

    protected $primaryKey = 'id';


    public function car()
    {
        return $this->hasMany(Car::class , 'catalog_id' , 'catalog_id');
    }

    public function carGroup()
    {
        return $this->hasMany(CarGroup::class , 'catalog_id' , 'catalog_id');
    }




}
