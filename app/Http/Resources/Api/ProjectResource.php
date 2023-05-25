<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray(Request $request): array
    {
        return [
            $this->attributes([
                'namespace',
                'name',
                'packagist_name',
                'maintainers',
                'is_hidden',
                'issues',
                'pull_requests',
                'downloads_total',
                'downloads_last_30_days',
                'debt_score',
            ]),
        ];
    }
}
