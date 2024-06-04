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
        Schema::create('camera', function (Blueprint $table) {
            $table->id();
            $table->foreignId('frontcamera_id')->constrained('frontcamera');
            $table->foreignId('rearcamera_id')->constrained('rearcamera');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camera');
    }
};
