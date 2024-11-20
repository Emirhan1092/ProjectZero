<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expertise extends Model
{
    use HasFactory;

    protected $table = 'experts';

    protected $guarded = ['id'];
    protected $fillable = [

        'user_id',
        'company_name',
        'email',
        'expertise_area',
        'number_of_services',
        'rating',
        'star',
        'start_date',
        'status',
    ];


    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
