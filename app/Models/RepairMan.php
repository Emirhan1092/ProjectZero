<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairMan extends Model
{
    use HasFactory;


    protected $table = 'repairmans';
    protected $fillable = [

        'user_id',
        'shop_name',
        'address',
        'phone_number',
        'star',
        'rating',
        'start_date',
        'certificates',
        'number_of_services',
        'status',

    ];

    protected $guarded = ['id'];


    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
