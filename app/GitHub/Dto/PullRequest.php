<?php

namespace App\GitHub\Dto;

class PullRequest
{
    use CastDates;

    public $body;

    public $created_at;

    public $draft;

    public $head_ref;

    public $html_url;

    public $node_id;

    public $number;

    public $title;

    /** @var Label[] */
    public $labels;

    /** @var User */
    public $user;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->head_ref ??= $data['head']['ref'] ?? null;

        $this->toCarbon($this->created_at);
    }
}
