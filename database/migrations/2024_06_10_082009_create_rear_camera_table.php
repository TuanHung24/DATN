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
        Schema::create('rear_camera', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_description_id')->constrained('product_description');
            $table->string('resolution',50);
            $table->text('record');
            $table->text('feature');
            $table->boolean('flash');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rear_camera');
    }
};
