<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    protected $guarded = [];

    #[Scope]
    protected function today($query)
    {
        return $query->whereDate('snapshot_date', '=', now());
    }
}
