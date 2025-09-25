<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            // Add nullable foreign key to hospital_uploads.id
            $table->uuid('hospital_upload_id')->nullable()->after('image_id');

            // If you want, you can add the constraint:
            $table->foreign('hospital_upload_id')
                  ->references('id')
                  ->on('hospital_uploads')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('assignments', function (Blueprint $table) {
            $table->dropForeign(['hospital_upload_id']);
            $table->dropColumn('hospital_upload_id');
        });
    }
};
