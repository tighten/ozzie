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
            $table->integer('pull_requests')->default(0);
            $table->integer('old_pull_requests')->default(0);
            $table->integer('issues')->default(0);
            $table->integer('old_issues')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
