<?php

use App\Models\Maintainer;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintainersRelationship extends Migration
{
    public function up()
    {
        // Before dropping the maintainers column, let's grab everything
        // to make new records in the maintainers table (and their assigned projects)
        $maintainers = [];
        DB::table('projects')->get()->each(function ($project) use (&$maintainers) {
            foreach (json_decode($project->maintainers, true) as $m) {
                $maintainers[$m][] = $project->id;
            }
        });

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

        // Add maintainers from the old column, and attach their projects
        collect($maintainers)->each(function ($projects, $maintainer) {
            $maintainer = Maintainer::updateOrCreate([
                'github_username' => $maintainer,
            ], [
                'user_id' => User::where('github_username', $maintainer)->first()->id ?? null,
            ]);

            $maintainer->projects()->attach($projects);
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
