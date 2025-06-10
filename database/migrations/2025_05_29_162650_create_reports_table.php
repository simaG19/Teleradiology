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
        Schema::create('reports', function (Blueprint $table) {
        $table->bigIncrements('id');
        $table->unsignedBigInteger('assignment_id');       // references assignments.id
        $table->string('pdf_path');                        // storage path of generated PDF
        $table->text('notes')->nullable();                 // optional free text
        $table->timestamps();

        $table->foreign('assignment_id')->references('id')->on('assignments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
