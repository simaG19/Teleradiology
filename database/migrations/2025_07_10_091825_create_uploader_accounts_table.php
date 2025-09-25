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
    Schema::create('uploader_accounts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('hospital_id')
              ->constrained('hospital_profiles')
              ->onDelete('cascade');
        $table->string('name');
        $table->string('email')->unique();
        $table->string('password');
        $table->timestamps();
    });
}

};
