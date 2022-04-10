<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Exceptions\InvalidDniFormatException;

class Dni
{
    const DNI_LENGTH_TO_CHECK = 9;

    public function __construct($dni)
    {
        $this->checkDniLength($dni);
        //if(preg_match('/[0-9]/', substr($dni, -1))) {
        if(preg_match('/\d$/', $dni)) {
            throw new InvalidDniFormatException("Last Dni character can't be a number");
        }
        throw new InvalidDniFormatException("Last Dni character can't be i,o,u,ñ");
    }

    /**
     * @param $dni
     * @throws InvalidDniLengthException
     */
    private function checkDniLength($dni): void
    {
        if (strlen($dni) !== self::DNI_LENGTH_TO_CHECK) {
            throw new InvalidDniLengthException('Dni string is not valid. It must contain exactly 9 characters');
        }
    }
}