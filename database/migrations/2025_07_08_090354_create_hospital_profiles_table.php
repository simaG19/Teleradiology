<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('hospital_profiles', function (Blueprint $table) {
        $table->id();

        // Link back to the users table (hospital user)
        $table->foreignId('user_id')
              ->constrained('users')
              ->onDelete('cascade');

        // Monthly file upload limit (0 = unlimited)
        $table->unsignedInteger('monthly_file_limit')->default(0)
              ->comment('Max DICOM files per month');

        // Number of uploader accounts hospital may create (0 = unlimited)
        $table->unsignedInteger('uploader_account_limit')->default(0)
              ->comment('Max uploader accounts');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
   public function down()
{
    Schema::dropIfExists('hospital_profiles');
}

};
