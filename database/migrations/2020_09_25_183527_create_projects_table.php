<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();

            $table->string('namespace');
            $table->string('name');
            $table->text('maintainers');
            $table->integer('issues_count')->unsigned()->nullable()->default(0);
            $table->integer('pull_requests_count')->unsigned()->nullable()->default(0);
            $table->longText('issues')->nullable();
            $table->longText('pull_requests')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
