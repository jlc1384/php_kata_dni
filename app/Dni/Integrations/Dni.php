<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Exceptions\InvalidDniFormatException;
use App\Dni\Exceptions\InvalidDniLetterException;

class Dni
{
    const DNI_LENGTH_TO_CHECK = 9;

    private string $dni;

    /**
     * @throws InvalidDniFormatException
     * @throws InvalidDniLengthException
     * @throws InvalidDniLetterException
     */
    public function __construct($dni)
    {
        $this->checkDniLength($dni);
        $this->checkDniStringStructure($dni);

        $dniNumber = substr($dni, 0, - 1);
        $dniLetter = strtoupper(substr($dni, -1));
        $remainder = $dniNumber % 23;
        $dniEquivalencesLetterRemainder = [
          "0" => "T",
          "1" => "R"
        ];

        if($dniLetter !== $dniEquivalencesLetterRemainder[$remainder]) {
            throw new InvalidDniLetterException('Dni string is not valid. The letter is not valid for these Dni numbers');
        }

        $this->dni = $dni;
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

    public function getDni()
    {
        return $this->dni;
    }
}