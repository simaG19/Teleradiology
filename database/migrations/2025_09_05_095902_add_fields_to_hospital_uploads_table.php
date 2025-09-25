<?php
// database/migrations/2025_xx_xx_add_fields_to_hospital_uploads_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('hospital_uploads', function (Blueprint $table) {
            if (! Schema::hasColumn('hospital_uploads', 'zip_path')) {
                $table->string('zip_path')->nullable()->after('id');
            }
            if (! Schema::hasColumn('hospital_uploads', 'file_count')) {
                $table->integer('file_count')->default(0)->after('zip_path');
            }
            if (! Schema::hasColumn('hospital_uploads', 'quoted_price')) {
                $table->decimal('quoted_price', 12, 2)->nullable()->after('file_count');
            }
        });

        // ensure hospital_profiles.billing_rate exists and is decimal
        Schema::table('hospital_profiles', function (Blueprint $table) {
            if (! Schema::hasColumn('hospital_profiles', 'billing_rate')) {
                $table->decimal('billing_rate', 12, 2)->default(0)->after('uploader_account_limit');
            }
        });
    }

    public function down()
    {
        Schema::table('hospital_uploads', function (Blueprint $table) {
            $table->dropColumn(['zip_path','file_count','quoted_price']);
        });

        // do not drop billing_rate automatically unless you intend to
    }
};
