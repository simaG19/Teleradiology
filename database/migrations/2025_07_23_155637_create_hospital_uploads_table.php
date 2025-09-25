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
    Schema::create('hospital_uploads', function (Blueprint $table) {
        $table->uuid('id')->primary();           // batch_no
        $table->foreignId('hospital_id')->constrained('hospital_profiles')->onDelete('cascade');
        $table->foreignId('uploader_id')->constrained('users')->onDelete('cascade');
        $table->string('zip_path');              // storage path to the ZIP
        $table->enum('urgency', ['normal','urgent']);
        $table->text('clinical_history')->nullable();
        $table->foreignId('file_type_id')->nullable()->constrained('file_types')->onDelete('set null');
        $table->enum('status', ['uploaded','quoted','in_progress','completed'])
              ->default('uploaded');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hospital_uploads');
    }
};
