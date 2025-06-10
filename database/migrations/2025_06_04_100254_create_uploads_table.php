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
      Schema::create('uploads', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('uploader_id');
        $table->string('original_zip_name');
        $table->string('stored_zip_name');
        $table->enum('status', ['uploaded', 'extracted'])->default('uploaded');
        $table->timestamps();

        $table->foreign('uploader_id')->references('id')->on('users')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uploads');
    }
};
