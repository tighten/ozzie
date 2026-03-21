<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\Unguarded;
use Illuminate\Database\Eloquent\Model;

#[Unguarded]
class Snapshot extends Model
{
    #[Scope]
    protected function today($query)
    {
        return $query->whereDate('snapshot_date', '=', now());
    }
}
