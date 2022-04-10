<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Exceptions\InvalidDniFormatException;

class Dni
{
    const DNI_LENGTH_TO_CHECK = 9;

    /**
     * @throws InvalidDniFormatException
     * @throws InvalidDniLengthException
     */
    public function __construct($dni)
    {
        $this->checkDniLength($dni);
        $this->checkDniStringStructure($dni);
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

    /**
     * @param $dni
     * @throws InvalidDniFormatException
     */
    private function checkDniStringStructure($dni): void
    {
        if (!preg_match('/^[XYZ\d]\d{7,7}[^UIOÑ\d]$/u', $dni)) {
            throw new InvalidDniFormatException("Dni wrong format");
        }
    }
}