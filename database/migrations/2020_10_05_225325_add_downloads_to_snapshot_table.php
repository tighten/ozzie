<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDownloadsToSnapshotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('snapshots', function (Blueprint $table) {
						$table->integer('download_totals')->default(0)->after('old_issue_count');
						$table->integer('download_last_30_days')->default(0)->after('download_totals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('snapshots', function (Blueprint $table) {
            $table->dropColumn(['download_totals', 'download_last_30_days']);
        });
    }
}
