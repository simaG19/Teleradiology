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
Schema::table('hospital_profiles', function (Blueprint $table) {
    $table->decimal('billing_rate', 8, 2)->default(0)
          ->comment('Rate per file uploaded (e.g. $0.50 per file)');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hospital_profiles', function (Blueprint $table) {
            //
        });
    }
};
