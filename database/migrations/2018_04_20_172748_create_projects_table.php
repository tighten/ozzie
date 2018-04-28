<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->decimal('debt_score', 3, 2)->default(0);
            $table->integer('pull_request_count')->default(0);
            $table->integer('old_pull_request_count')->default(0);
            $table->integer('issue_count')->default(0);
            $table->integer('old_issue_count')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
