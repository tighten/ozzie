<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class LabelData extends DataTransferObject
{
    public $id;
    public $node_id;
    public $url;
    public $name;
    public $color;
    public $default;
    public $description;
}
