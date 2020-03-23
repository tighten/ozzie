<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class IssueData extends DataTransferObject
{
    // Identifiers -------------------------------------------------------------

    /** @var integer */
    public $id;

    /** @var string */
    public $node_id;

    // Details -----------------------------------------------------------------

    /** @var integer */
    public $number;

    /** @var string */
    public $title;

    /** @var string */
    public $body;

    /** @var integer */
    public $comments;

    /** @var \App\GitHub\Dto\LabelData[] */
    public $labels;

    /** @var string */
    public $state;

    /** @var bool */
    public $locked;

    /** @var string|null */
    public $milestone;

    // People ------------------------------------------------------------------

    /** @var \App\GitHub\Dto\UserData */
    public $user;

    /** @var array|null */
    public $assignee;

    /** @var array */
    public $assignees;

    /** @var string */
    public $author_association;

    /** @var array|null */
    public $pull_request;

    // Dates -------------------------------------------------------------------

    /** @var string */
    public $created_at;

    /** @var string */
    public $updated_at;

    /** @var string|null */
    public $closed_at;

    // Urls --------------------------------------------------------------------

    /** @var string */
    public $html_url;

    /** @var string */
    public $url;

    /** @var string */
    public $repository_url;

    /** @var string */
    public $labels_url;

    /** @var string */
    public $comments_url;

    /** @var string */
    public $events_url;
}
