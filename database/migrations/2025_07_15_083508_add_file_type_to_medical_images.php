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
    Schema::table('medical_images', function (Blueprint $table) {
        $table->foreignId('file_type_id')
              ->nullable()
              ->constrained('file_types')
              ->onDelete('set null');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medical_images', function (Blueprint $table) {
            //
        });
    }
};
