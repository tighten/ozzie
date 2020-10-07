<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Pr extends DataTransferObject
{
    use CastDates;

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

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
        $this->toCarbon($this->created_at);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->node_id,
            'title' => $this->title,
            'number' => $this->number,
            'user' => $this->user->login,
            'base' => $this->base->label,
            'head' => $this->head->label,
            'url' => $this->html_url,
        ];
    }
}
