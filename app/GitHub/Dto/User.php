<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class User extends DataTransferObject
{
    public $html_url;

    public $login;

    protected bool $ignoreMissing = true;
}
