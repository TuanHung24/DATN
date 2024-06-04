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
        Schema::create('rearcamera', function (Blueprint $table) {
            $table->id();
            $table->string('resolutioncamera');
            $table->string('recordcamera');
            $table->string('feature');
            $table->boolean('flash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rearcamera');
    }
};
