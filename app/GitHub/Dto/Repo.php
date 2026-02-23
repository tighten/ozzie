<?php

namespace App\GitHub\Dto;

class Repo
{
    public $namespace;

    public $name;

    public $full_name;

    public $archived;

    public $fork;

    public function __construct(array $parameters)
    {
        [$namespace, $name] = explode('/', $parameters['full_name']);

        $this->namespace = $namespace;
        $this->name = $name;
        $this->full_name = $parameters['full_name'];
        $this->archived = $parameters['archived'];
        $this->fork = $parameters['fork'];
    }
}
