<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Issue extends DataTransferObject
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

    protected bool $ignoreMissing = true;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
        $this->toCarbon($this->created_at);
    }
}
