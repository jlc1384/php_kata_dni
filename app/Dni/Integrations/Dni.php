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
        //if(preg_match('(i|o|ñ|u)', strtolower($dni)) === 1) {
        if (preg_match('/[UIOÑ]$/u', $dni)) {
            throw new InvalidDniFormatException("Last Dni character can't be i,o,u,ñ");
        }
        if(!preg_match('/\d{7,7}.$/', $dni)) {
            throw new InvalidDniFormatException("Dni can't have characters in the middle of the string");
        }
        throw new InvalidDniFormatException("Dni must start by a number X, Y or Z");
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