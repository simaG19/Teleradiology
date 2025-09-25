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
    Schema::table('hospital_profiles', function (Blueprint $table) {
        $table->boolean('is_active')->default(true)->after('uploader_account_limit');
    });
}

public function down()
{
    Schema::table('hospital_profiles', function (Blueprint $table) {
        $table->dropColumn('is_active');
    });
}

};
