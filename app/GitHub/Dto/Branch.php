<?php

namespace App\GitHub\Dto;

class Branch
{
    public $label;

    public $ref;

    public $sha;

    public $user;

    public $repo;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
