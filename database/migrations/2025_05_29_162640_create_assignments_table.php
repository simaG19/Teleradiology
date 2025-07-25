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
       Schema::create('assignments', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('image_id');            // references medical_images.id
        $table->unsignedBigInteger('assigned_by');         // admin user
        $table->unsignedBigInteger('assigned_to');         // reader user
        $table->string('deadline');
        $table->timestamp('assigned_at')->nullable();
        $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
        $table->timestamps();

        $table->foreign('image_id')->references('id')->on('medical_images')->onDelete('cascade');
        $table->foreign('assigned_by')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('assigned_to')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
