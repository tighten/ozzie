<?php

namespace App\GitHub\Dto;

use Illuminate\Support\Carbon;

trait CastDates
{
    public function toCarbon(?string &$date): void
    {
        if (is_null($date)) {
            return;
        }

        $date = Carbon::parse($date);
    }
}
