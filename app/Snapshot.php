<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    protected $guarded = [];

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', '=', now()->format('Y-m-d'));
    }

    public function project()
    {
        return $this->belongsTo('App\SnapshotProject');
    }
}
