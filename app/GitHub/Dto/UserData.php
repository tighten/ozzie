<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class UserData extends DataTransferObject
{
    public $login;
    public $id;
    public $node_id;
    public $avatar_url;
    public $gravatar_id;
    public $url;
    public $html_url;
    public $followers_url;
    public $following_url;
    public $gists_url;
    public $starred_url;
    public $subscriptions_url;
    public $organizations_url;
    public $repos_url;
    public $events_url;
    public $received_events_url;
    public $type;
    public $site_admin;
}
