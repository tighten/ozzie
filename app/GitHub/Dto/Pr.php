<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Pr extends DataTransferObject
{
    use CastDates;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);
        $this->toCarbon($this->created_at);
        $this->toCarbon($this->updated_at);
        $this->toCarbon($this->closed_at);
        $this->toCarbon($this->merged_at);
    }

    // Identifiers -------------------------------------------------------------

    public $id;
    public $node_id;
    public $merge_commit_sha;

    // Details -----------------------------------------------------------------

    public $number;
    public $title;
    public $body;
    /** @var \App\GitHub\Dto\Label[] */
    public $labels;
    public $state;
    public $locked;
    public $active_lock_reason;
    public $milestone;
    public $draft;

    // People ------------------------------------------------------------------

    /** @var \App\GitHub\Dto\User */
    public $user;
    public $assignee;
    public $assignees;
    public $requested_reviewers;
    public $author_association;
    public $requested_teams;

    // Dates -------------------------------------------------------------------

    public $created_at;
    public $updated_at;
    public $closed_at;
    public $merged_at;

    // Branches -------------------------------------------------------------------

    /** @var \App\GitHub\Dto\Branch */
    public $head;
    /** @var \App\GitHub\Dto\Branch */
    public $base;

    // Urls --------------------------------------------------------------------

    public $html_url;
    public $url;
    public $comments_url;
    public $diff_url;
    public $patch_url;
    public $issue_url;
    public $commits_url;
    public $review_comments_url;
    public $review_comment_url;
    public $statuses_url;
    public $_links;
}
