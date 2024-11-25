<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSchemas extends Model
{
    use HasFactory;

    protected $table = 'catalog_car_schemas';

    protected $guarded = ['id'];



    public function carSubGroup()
    {
        return $this->belongsTo(CarSubGroup::class , 'group_id' , 'group_id' );
    }

    public function carPart()
    {
        return $this->HasMany(CarPart::class , 'part_group_id' , 'group_id' );
    }
}
