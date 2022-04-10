<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Exceptions\InvalidDniFormatException;

class Dni
{
    public function __construct($dni)
    {
        if(strlen($dni) > 9) {
            throw new InvalidDniLengthException('Dni string is too long');
        }
        if(strlen($dni) < 9) {
            throw new InvalidDniLengthException('Dni string is too short');
        }
        throw new InvalidDniFormatException("Last Dni character can't be a number");
    }
}