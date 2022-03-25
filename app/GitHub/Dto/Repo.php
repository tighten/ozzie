<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Repo extends DataTransferObject
{
    public $namespace;
    public $name;
    public $full_name;
    public $archived;
    public $fork;

    protected bool $ignoreMissing = true;

    public function __construct(array $parameters)
    {
        [$namespace, $name] = explode('/', $parameters['full_name']);

        parent::__construct([
            'namespace' => $namespace,
            'name' => $name,
            'full_name' => $parameters['full_name'],
            'archived' => $parameters['archived'],
            'fork' => $parameters['fork'],
        ]);
    }
}
