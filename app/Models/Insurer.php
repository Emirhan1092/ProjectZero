<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insurer extends Model
{
    use HasFactory;

    protected $table = 'insurers';

    protected $guarded = ['id'];
    protected $fillable = [
        'insurer_name',
        'user_id',
        'insurance_company',
        'email',
        'phone',
        'address',
        'image',
    ];


    public function user()
    {
        return $this->belongsTo(User::class , 'user_id' , 'id');
    }
}
