<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
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

    public function down(): void
    {
        Schema::dropIfExists('snapshots');
    }
};
