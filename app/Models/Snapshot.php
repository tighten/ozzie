<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    protected $guarded = [];

    public function scopeToday($query)
    {
        return $query->whereDate('snapshot_date', '=', now());
    }
}
