<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CarModel extends Model
{
    use HasFactory;

    protected $table = 'catalog_models';


    protected $primaryKey = 'id';



    public function dataCars():HasMany
    {
        return $this->HasMany(Car::class, 'model_id', 'model_id');

    }


}
