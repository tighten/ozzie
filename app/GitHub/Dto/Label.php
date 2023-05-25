<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Label extends DataTransferObject
{
    public $color;

    public $name;

    protected bool $ignoreMissing = true;
}
