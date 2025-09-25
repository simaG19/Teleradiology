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
    Schema::create('file_types', function (Blueprint $table) {
        $table->id();
        $table->string('name');            // e.g. “X‑ray”, “CT scan”
        $table->decimal('price_per_file', 10, 2);    // birr per file
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_types');
    }
};
