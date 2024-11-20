<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lawyer extends Model
{
    use HasFactory;

    protected $table = 'lawyers';

    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'image',
        'specialization',
        'license_number',
        'license_expiry'
    ];

    public function user()
    {
        return $this->belongsTo(User::class ,'user_id' , 'id');
    }
}
