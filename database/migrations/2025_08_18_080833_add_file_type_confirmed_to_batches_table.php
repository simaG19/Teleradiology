<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            // quoted_price (add if missing)
            if (! Schema::hasColumn('batches', 'quoted_price')) {
                $table->decimal('quoted_price', 10, 2)->nullable()->after('clinical_history');
            }

            // file_type_id (add if missing)
            if (! Schema::hasColumn('batches', 'file_type_id')) {
                $table->unsignedBigInteger('file_type_id')->nullable()->after('quoted_price');
                // add FK constraint only if file_types table exists
                if (Schema::hasTable('file_types')) {
                    $table->foreign('file_type_id')->references('id')->on('file_types')->onDelete('set null');
                }
            }

            // archive_path
            if (! Schema::hasColumn('batches', 'archive_path')) {
                $table->string('archive_path')->nullable()->after('file_type_id');
            }

            // confirmed flag
            if (! Schema::hasColumn('batches', 'confirmed')) {
                $table->boolean('confirmed')->default(false)->after('quoted_price');
            }
        });
    }

    public function down(): void
    {
        Schema::table('batches', function (Blueprint $table) {
            if (Schema::hasColumn('batches', 'confirmed')) {
                $table->dropColumn('confirmed');
            }
            if (Schema::hasColumn('batches', 'archive_path')) {
                $table->dropColumn('archive_path');
            }

            if (Schema::hasColumn('batches', 'file_type_id')) {
                // attempt to drop FK safely
                $sm = Schema::getConnection()->getDoctrineSchemaManager();
                $doctrineTable = $sm->listTableDetails('batches');
                if ($doctrineTable->hasForeignKey('batches_file_type_id_foreign')) {
                    $table->dropForeign(['file_type_id']);
                } else {
                    // if foreign key name different, try to drop by column (Laravel will handle)
                    try {
                        $table->dropForeign(['file_type_id']);
                    } catch (\Exception $e) {
                        // ignore if not present
                    }
                }
                $table->dropColumn('file_type_id');
            }

            if (Schema::hasColumn('batches', 'quoted_price')) {
                $table->dropColumn('quoted_price');
            }
        });
    }
};
