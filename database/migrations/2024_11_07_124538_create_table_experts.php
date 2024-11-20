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
        Schema::create('experts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('email')->unique();
            $table->text('company_name');
            $table->bigInteger('phone_number');
            $table->string('expertise_area')->nullable();
            $table->unsignedBigInteger('number_of_services')->nullable();
            $table->unsignedBigInteger('rating')->nullable();
            $table->unsignedBigInteger('status')->default(1);
            $table->unsignedBigInteger('star')->nullable();
            $table->dateTime('start_date')->nullable();
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experts');
    }
};
