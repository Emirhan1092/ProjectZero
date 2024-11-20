<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarFilter extends Model
{
    use HasFactory;

    protected $table = 'catalog_cars_filters';


    protected $guarded = ['id'];



}
