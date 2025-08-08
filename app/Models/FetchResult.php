<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FetchResult extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'type',
        'success',
    ];

    protected $casts = [
        'success' => 'boolean',
    ];

    public static function packagistSuccess(Project $project): self
    {
        return self::create([
            'project_id' => $project->id,
            'type' => 'packagist',
            'success' => true,
        ]);
    }

    public static function packagistFail(Project $project): self
    {
        return self::create([
            'project_id' => $project->id,
            'type' => 'packagist',
            'success' => false,
        ]);
    }

    public static function githubSuccess(Project $project): self
    {
        return self::create([
            'project_id' => $project->id,
            'type' => 'github',
            'success' => true,
        ]);
    }

    public static function githubFail(Project $project): self
    {
        return self::create([
            'project_id' => $project->id,
            'type' => 'github',
            'success' => false,
        ]);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}
