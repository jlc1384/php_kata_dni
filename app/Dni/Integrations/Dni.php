<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;

class Dni
{
    public function __construct($dni)
    {
        if(strlen($dni) > 9) {
            throw new InvalidDniLengthException('Dni string is too long');
        }
        throw new InvalidDniLengthException('Dni string is too short');
    }
}