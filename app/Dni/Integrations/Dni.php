<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;

class Dni
{
    public function __construct()
    {
        throw new InvalidDniLengthException('Dni string is too long');
    }
}