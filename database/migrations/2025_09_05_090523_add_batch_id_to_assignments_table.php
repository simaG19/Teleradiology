<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('assignments', function (Blueprint $table) {
            // If your batches.id is UUID, adjust type accordingly:
            // use $table->uuid('batch_id')->nullable()->after('image_id');
            $table->uuid('batch_id')->nullable()->after('image_id');

            // optionally add foreign key if batches table exists and you want FK
            // $table->foreign('batch_id')->references('id')->on('batches')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('assignments', function (Blueprint $table) {
            // if you added a foreign key, drop it first
            // $table->dropForeign(['batch_id']);
            $table->dropColumn('batch_id');
        });
    }
};
