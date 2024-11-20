<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateAccidentsTable extends Migration
{ /** * Run the migrations. */
    public function up(): void
    { Schema::create('accidents', function (Blueprint $table)
    {
        $table->id();
        $table->unsignedBigInteger('vehicle_id');
        $table->unsignedBigInteger('user_id');
        $table->unsignedBigInteger('repair_id')->nullable(); // Unsigned ve nullable olmalı
        $table->string('accident_type');
        $table->dateTime('accident_date');
        $table->text('description')->nullable();
        $table->string('accident_status');
        $table->timestamps();


        $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('repair_id')->references('id')->on('users')->onDelete('set null'); });

    }
    /** * Reverse the migrations. */
    public function down(): void
    {
        Schema::dropIfExists('accidents');
    }
}
