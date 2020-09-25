<?php

use App\Projects;
use App\Snapshot;
use App\SnapshotProject;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class NormaliseSnapshotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('namespace');
            $table->string('name');
        });

        Schema::table('snapshots', function (Blueprint $table) {
            $table->foreignId('project_id')->after('name');
        });

        $projects = (new Projects)->load();
        if (!$projects->isEmpty()) {
            $data = $projects->map(function ($project) {
                return [
                    'namespace' => $project->namespace,
                    'name' => $project->name
                ];
            });
            DB::table('projects')->insert($data->toArray());
            SnapshotProject::all(['id', 'name'])->each(function($project) {
                Snapshot::where('name', '=', $project->name)->update([
                    'project_id' => $project->id
                ]);
            });
        }

        Schema::table('snapshots', function (Blueprint $table) {
            $table->dropColumn('name');
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
            $table->string('name')->after('id');
        });

        SnapshotProject::all(['id', 'name'])->each(function($project) {
            Snapshot::where('project_id', '=', $project->id)->update([
                'name' => $project->name
            ]);
        });

        Schema::table('snapshots', function (Blueprint $table) {
            $table->dropColumn('project_id');
        });

        Schema::dropIfExists('projects');
    }
}
