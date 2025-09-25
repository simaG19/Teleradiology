<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('file_types', function (Blueprint $table) {
            // nullable so existing rows won't break; adjust if you want NOT NULL with default
            $table->string('anatomy')->nullable()->after('name');
        });
    }

    public function down(): void
    {
        Schema::table('file_types', function (Blueprint $table) {
            $table->dropColumn('anatomy');
        });
    }
};
