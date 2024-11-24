<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarSubGroup extends Model
{
    use HasFactory;


    protected $table = 'catalog_sub_groups';


    protected $primaryKey = 'id';

    public function carGroup()
    {
        return $this->belongsTo(CarGroup::class , 'parent_id', 'group_id');
    }

    public function carSchemas()
    {
        return $this->hasMany(CarSchemas::class, 'group_id', 'group_id');
    }
}
