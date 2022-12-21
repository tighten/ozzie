<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintainersRelationship extends Migration
{
    public function up()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('maintainers');
        });

        Schema::create('maintainers', function (Blueprint $table) {
            $table->id();
            $table->string('github_username');
            $table->string('user_id')->nullable();
            $table->timestamps();
        });

        Schema::create('maintainer_project', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintainer_id');
            $table->unsignedBigInteger('project_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('maintainers');
        Schema::dropIfExists('maintainer_project');

        Schema::table('projects', function (Blueprint $table) {
            $table->text('maintainers');
        });
    }
}
