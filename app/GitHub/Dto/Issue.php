<?php

namespace App\GitHub\Dto;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class Issue extends DataTransferObject
{
    use CastDates;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
        $this->toCarbon($this->created_at);
        $this->toCarbon($this->updated_at);
        $this->toCarbon($this->closed_at);
    }

    // Identifiers -------------------------------------------------------------

    public $id;
    public $node_id;

    // Details -----------------------------------------------------------------

    public $number;
    public $title;
    public $body;
    public $comments;
    /** @var \App\GitHub\Dto\Label[] */
    public $labels;
    public $state;
    public $locked;
    public $milestone;

    // People ------------------------------------------------------------------

    /** @var \App\GitHub\Dto\User */
    public $user;
    public $assignee;
    public $assignees;
    public $author_association;
    public $pull_request;

    // Dates -------------------------------------------------------------------

    public $created_at;
    public $updated_at;
    public $closed_at;

    // Urls --------------------------------------------------------------------

    public $html_url;
    public $url;
    public $repository_url;
    public $labels_url;
    public $comments_url;
    public $events_url;
}
