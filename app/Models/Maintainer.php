<?php

namespace App\Models;

use App\Observers\MaintainerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Unguarded]
#[ObservedBy([MaintainerObserver::class])]
class Maintainer extends Model
{
    use HasFactory;

    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class);
    }
}
