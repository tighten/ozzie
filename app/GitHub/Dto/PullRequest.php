<?php

namespace App\GitHub\Dto;

class PullRequest
{
    use CastDates;

    public $body;

    public $created_at;

    public $draft;

    public $html_url;

    public $node_id;

    public $number;

    public $title;

    /** @var \App\GitHub\Dto\Label[] */
    public $labels;

    /** @var \App\GitHub\Dto\User */
    public $user;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->toCarbon($this->created_at);
    }
}
