<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class PullRequest extends DataTransferObject
{
    use CastDates;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
        $this->toCarbon($this->created_at);
    }

    public $body;
    public $created_at;
    public $draft;
    public $html_url;
    public $node_id;
    public $number;
    public $title;

    /** @var \App\GitHub\Dto\Branch */
    public $base;

    /** @var \App\GitHub\Dto\Branch */
    public $head;

    /** @var \App\GitHub\Dto\Label[] */
    public $labels;

    /** @var \App\GitHub\Dto\User */
    public $user;

    protected $ignoreMissing = true;
}
