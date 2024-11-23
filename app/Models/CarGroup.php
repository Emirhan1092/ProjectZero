<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarGroup extends Model
{
    use HasFactory;


    protected $table = 'catalog_groups';


    protected $primaryKey = 'id';



    public function carPart()
    {
        return $this->hasMany(CarPart::class, 'car_id', 'car_id');
    }

    public function carGroup()
    {
        return $this->hasMany(CarSubGroup::class, 'group_id', 'parent_id');
    }







}
