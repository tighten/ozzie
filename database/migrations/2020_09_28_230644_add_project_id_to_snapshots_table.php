<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectIdToSnapshotsTable extends Migration
{
    public function up()
    {
        Schema::table('snapshots', function (Blueprint $table) {
            $table->bigInteger('project_id')->unsigned()->after('id');
        });
    }

    public function down()
    {
        Schema::table('snapshots', function (Blueprint $table) {
            $table->dropColumn('project_id');
        });
    }
}
