<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $guarded = ['id'];


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
