<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('brand');  //marka
            $table->string('model'); //model
            $table->year('year');  //üretim yılı
            $table->string('color');
            $table->unsignedInteger('kilometers');
            $table->string('vehicle_register_plate', 15); //plaka
            $table->string('VIN', 17)->unique();   //şaşi numarası
            $table->string('engine_number');  //motor numarası
            $table->string('fuel_type'); //yakıt tipi
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
}
