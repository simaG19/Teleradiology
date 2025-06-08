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
        Schema::create('medical_images', function (Blueprint $table) {
            $table->id();
            $table->string('batch_no');
            $table->unsignedBigInteger('uploader_id');         // references users.id
            $table->string('filename');                        // stored file name
            $table->string('original_name');                   // original upload name
            $table->string('mime_type');                       // e.g. application/dicom
            $table->enum('status', ['uploaded', 'assigned', 'reading', 'completed'])->default('uploaded');
            $table->timestamps();
            $table->foreign('uploader_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_images');
    }
};
