<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class IssueData extends DataTransferObject
{
    // Identifiers -------------------------------------------------------------

    public $id;
    public $node_id;

    // Details -----------------------------------------------------------------

    public $number;
    public $title;
    public $body;
    public $comments;
    /** @var \App\GitHub\Dto\LabelData[] */
    public $labels;
    public $state;
    public $locked;
    public $milestone;

    // People ------------------------------------------------------------------

    /** @var \App\GitHub\Dto\UserData */
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
