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
    Schema::table('batches', function (Blueprint $table) {
        // Price in birr, nullable until admin sets it
        $table->decimal('quoted_price', 10, 2)->nullable()->after('clinical_history');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            //
        });
    }
};
