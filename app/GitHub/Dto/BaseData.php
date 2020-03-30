<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class BaseData extends DataTransferObject
{
    public $label;
    public $ref;
    public $sha;
    public $user;
    public $repo;
}
