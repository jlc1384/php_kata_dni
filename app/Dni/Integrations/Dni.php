<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Exceptions\InvalidDniFormatException;

class Dni
{
    const DNI_LENGTH_TO_CHECK = 9;

    public function __construct($dni)
    {
        if(strlen($dni) > self::DNI_LENGTH_TO_CHECK) {
            throw new InvalidDniLengthException('Dni string is too long');
        }
        if(strlen($dni) < self::DNI_LENGTH_TO_CHECK) {
            throw new InvalidDniLengthException('Dni string is too short');
        }
        throw new InvalidDniFormatException("Last Dni character can't be a number");
    }
}