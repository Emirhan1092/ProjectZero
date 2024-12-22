<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerInformation extends Model
{
    Use HasFactory;

    protected $table = 'customer_files_information';

    protected $fillable = [
         'id',
         'saved_by_name',
         'saved_by_id',
         'customer_informations',
         'files',
         'part_info',
        'insurer_informations',
         'created_at',
         'updated_at',
    ];


    public function repairman()
    {
        return $this->hasMany(RepairMan::class, 'saved_by_id', 'user_id');
    }
}
