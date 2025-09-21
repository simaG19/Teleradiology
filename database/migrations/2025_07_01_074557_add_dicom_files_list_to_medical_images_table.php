<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('medical_images', function (Blueprint $table) {
            if (!Schema::hasColumn('medical_images', 'file_size')) {
                $table->bigInteger('file_size')->nullable()->after('mime_type');
            }
            if (!Schema::hasColumn('medical_images', 'dicom_files_list')) {
                $table->json('dicom_files_list')->nullable()->after('file_size');
            }
        });
    }

    public function down()
    {
        Schema::table('medical_images', function (Blueprint $table) {
            $table->dropColumn(['file_size', 'dicom_files_list']);
        });
    }
};
