<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function show()
    {
        $hacktoberfest = (bool) Carbon::now()->isSameMonth(Carbon::parse('October'));

        return view('dashboard', [
            'projects' => Project::all(),
            'hacktoberfest' => $hacktoberfest,
        ]);
    }
}
