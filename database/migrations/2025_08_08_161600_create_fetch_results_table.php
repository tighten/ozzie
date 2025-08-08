<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fetch_results', function (Blueprint $table) {
            $table->id();

            $table->foreignId('project_id')->constrained();
            $table->string('type');
            $table->boolean('success')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fetch_results');
    }
};
