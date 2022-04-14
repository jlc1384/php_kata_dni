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
        $dniNumber = str_replace("X", '0', $dniNumber);
        $dniLetter = strtoupper(substr($dni, -1));
        $remainder = $dniNumber % 23;
        $dniEquivalencesLetterRemainder = ["0" => "T", "1" => "R", "2" => "W", "3" => "A", "4" => "G", "5" => "M",
            "6" => "Y", "7" => "F", "8" => "P", "9" => "D", "10" => "X", "11" => "B", "12" => "N", "13" => "J",
            "14" => "Z", "15" => "S", "16" => "Q", "17" => "V", "18" => "H", "19" => "L", "20" => "C", "21" => "K",
            "22" => "E"
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