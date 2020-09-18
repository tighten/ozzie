<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
    // Eloquent should ignore timestamps, since we only want
    // created_at and MySQL is handling that for us on insert
    public $timestamps = false;

    protected $guarded = [];

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', '=', now()->format('Y-m-d'));
    }
}
