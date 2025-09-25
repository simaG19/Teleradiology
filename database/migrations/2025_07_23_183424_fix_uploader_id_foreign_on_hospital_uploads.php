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
     // in the new migration’s up():
Schema::table('hospital_uploads', function(Blueprint $table){
    $table->dropForeign(['uploader_id']);
    $table->foreignId('uploader_id')
          ->change()
          ->constrained('uploader_accounts')
          ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospital_uploads', function (Blueprint $table) {
            //
        });
    }
};
