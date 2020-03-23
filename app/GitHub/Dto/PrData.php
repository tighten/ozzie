<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class PrData extends DataTransferObject
{
    public $url;

    public $id;

    public $node_id;

    public $html_url;

    public $diff_url;

    public $patch_url;

    public $issue_url;

    public $number;

    public $state;

    public $locked;

    public $title;

    /** @var \App\GitHub\Dto\UserData */
    public $user;

    public $body;

    public $created_at;

    public $updated_at;

    public $closed_at;

    public $merged_at;

    public $merge_commit_sha;

    public $assignee;

    public $assignees;

    public $requested_reviewers;

    public $requested_teams;

    /** @var \App\GitHub\Dto\LabelData[] */
    public $labels;

    public $milestone;

    public $draft;

    public $commits_url;

    public $review_comments_url;

    public $review_comment_url;

    public $comments_url;

    public $statuses_url;

    public $head;

    public $base;

    public $_links;

    public $author_association;
}
