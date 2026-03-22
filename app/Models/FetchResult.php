<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['project_id', 'type', 'success'])]
class FetchResult extends Model
{
    use HasFactory;

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

    protected function casts(): array
    {
        return [
            'success' => 'boolean',
        ];
    }
}
