<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GithubIssueController extends Controller
{
    protected function parseMarkdown(string $markdown): string
    {
        return Http::withHeaders(['Authorization' => config('github.rateLimitToken')])
            ->post('https://api.github.com/markdown', ['text' => $markdown])->body();
    }
}
