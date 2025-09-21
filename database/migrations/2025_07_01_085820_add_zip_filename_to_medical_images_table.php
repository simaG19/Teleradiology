<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('medical_images', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_images', 'zip_filename')) {
                $table->string('zip_filename')->nullable()->after('filename');
            }
        });
    }

    public function down()
    {
        Schema::table('medical_images', function (Blueprint $table) {
            $table->dropColumn('zip_filename');
        });
    }
};
