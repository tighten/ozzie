<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSnapshotsTable extends Migration
{
    public function up()
    {
        Schema::create('snapshots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('snapshot_date');
            $table->string('debt_score')->default(0);
            $table->integer('pull_request_count')->default(0);
            $table->integer('old_pull_request_count')->default(0);
            $table->integer('issue_count')->default(0);
            $table->integer('old_issue_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('snapshots');
    }
}
