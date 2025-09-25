<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('batches', function (Blueprint $table) {
            // Add the file_type_id column, nullable for existing records
            $table->foreignId('file_type_id')
                  ->nullable()
                  ->after('clinical_history')
                  ->constrained('file_types')
                  ->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropConstrainedForeignId('file_type_id');
        });
    }
};
