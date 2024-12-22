<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accident extends Model
{
    use HasFactory;

    protected $table = 'accidents';
    protected $guarded = ['id'] ;

    /**
     *
     * @var array
     */
    protected $fillable = [
        'vehicle_id',
        'user_id',
        'repairman_id',
        'accident_type',
        'accident_date',
        'description',
        'accident_status',
    ];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class , 'vehicle_id' , 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
