<?php

namespace App\GitHub\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class Repo extends DataTransferObject
{
    public $namespace;
    public $name;
    public $archived;

    public function __construct(array $parameters)
    {
        [$namespace, $name] = explode('/', $parameters['full_name']);

        parent::__construct([
            'namespace' => $namespace,
            'name' => $name,
            'archived' => $parameters['archived'],
        ]);
    }

    protected $ignoreMissing = true;
}
