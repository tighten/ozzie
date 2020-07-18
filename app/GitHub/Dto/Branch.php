<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Branch extends DataTransferObject
{
    public $label;
    public $ref;
    public $sha;
    public $user;
    public $repo;

    protected $ignoreMissing = true;
}
