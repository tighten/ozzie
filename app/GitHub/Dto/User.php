<?php

namespace App\GitHub\Dto;

class User
{
    public $html_url;

    public $login;

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
