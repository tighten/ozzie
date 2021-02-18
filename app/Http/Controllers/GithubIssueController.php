<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class GithubIssueController extends Controller
{
    protected function parseMarkdown(string $markdown): string
    {
        $response = Http::post('https://api.github.com/markdown', ['text' => $markdown]);
        if ($response->failed()) {
            return sprintf(
                'Something went wrong. Unable to parse markdown. <!-- (%s) %s-->',
                $response->status(),
                optional($response->object())->message
            );
        }
        return $response->body();
    }
}
