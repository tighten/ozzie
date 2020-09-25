<?php

namespace App\GitHub\Dto;

use Carbon\Carbon;

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
