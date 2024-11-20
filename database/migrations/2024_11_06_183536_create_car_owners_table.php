<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('car_owners', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->UnsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('accident_id')->nullable();
            $table->string('name');
            $table->string('licence_informations');
            $table->string('email');
            $table->bigInteger('phone_number');
            $table->string('address');
            $table->string('image')->nullable();
            $table->dateTime('birth_date');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vehicle_id')->references('id')->on('vehicles');
            $table->foreign('accident_id')->references('id')->on('accidents');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('car_owners');
    }
};
