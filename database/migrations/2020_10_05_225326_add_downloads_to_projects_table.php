<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('downloads_total')->unsigned()->default(0)->after('pull_requests');
            $table->integer('downloads_last_30_days')->unsigned()->default(0)->after('downloads_total');
        });
    }

    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['downloads_total', 'downloads_last_30_days']);
        });
    }
};
