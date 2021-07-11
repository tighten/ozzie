<?php

namespace App\GitHub;

use Illuminate\Support\Facades\Http;

class ParseMarkdown
{
    public function __invoke(string $markdown): string
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
