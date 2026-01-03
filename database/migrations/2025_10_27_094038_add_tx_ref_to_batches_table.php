<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTxRefToBatchesTable extends Migration
{
    public function up()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->string('tx_ref')->nullable()->after('id'); // adjust after() column as you like
        });
    }

    public function down()
    {
        Schema::table('batches', function (Blueprint $table) {
            $table->dropColumn('tx_ref');
        });
    }
}
