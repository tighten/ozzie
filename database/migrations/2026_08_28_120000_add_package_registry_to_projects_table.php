<?php

use App\Enums\PackageRegistry;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->string('package_registry')->default(PackageRegistry::Unknown->value)->after('packagist_name');
            $table->string('npm_name')->nullable()->after('package_registry');
        });

        // Anything we already have a Packagist name for is a Composer package;
        // everything else stays unknown until it's detected or set in Nova.
        DB::table('projects')
            ->whereNotNull('packagist_name')
            ->update(['package_registry' => PackageRegistry::Packagist->value]);
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn(['package_registry', 'npm_name']);
        });
    }
};
