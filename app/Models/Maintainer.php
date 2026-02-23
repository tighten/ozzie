<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintainer extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
