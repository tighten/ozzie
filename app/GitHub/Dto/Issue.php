<?php

namespace App\GitHub\Dto;

class Issue
{
    use CastDates;

    public $created_at;

    public $html_url;

    public $pull_request;

    public $title;

    public $number;

    public $body;

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
