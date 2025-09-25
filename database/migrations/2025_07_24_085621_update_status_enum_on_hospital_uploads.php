<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Change enum to include 'assigned'
        Schema::table('hospital_uploads', function (Blueprint $table) {
            $table->enum('status', ['uploaded','assigned','completed'])
                  ->default('uploaded')
                  ->change();
        });
    }

    public function down(): void
    {
        // Revert back if needed (drops 'assigned')
        Schema::table('hospital_uploads', function (Blueprint $table) {
            $table->enum('status', ['uploaded','completed'])
                  ->default('uploaded')
                  ->change();
        });
    }
};
