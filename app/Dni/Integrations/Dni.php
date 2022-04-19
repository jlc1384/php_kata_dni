<?php

namespace App\Dni\Integrations;

use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Exceptions\InvalidDniFormatException;
use App\Dni\Exceptions\InvalidDniLetterException;

class Dni
{
    private const DNI_LENGTH_TO_CHECK = 9;
    private const DNI_DIVISOR = 23;
    private const EQUIVALENCE_FIRST_LETTER = ["X", "Y", "Z"];
    private const EQUIVALENCE_FIRST_LETTER_DIGIT = ['0', '1', '2'];
    private const EQUIVALENCES_REMAINDER = ["0" => "T", "1" => "R", "2" => "W", "3" => "A", "4" => "G", "5" => "M",
        "6" => "Y", "7" => "F", "8" => "P", "9" => "D", "10" => "X", "11" => "B", "12" => "N", "13" => "J",
        "14" => "Z", "15" => "S", "16" => "Q", "17" => "V", "18" => "H", "19" => "L", "20" => "C", "21" => "K",
        "22" => "E"
    ];

    private string $dni;

    /**
     * Dni constructor.
     * @param string $dni
     * @throws InvalidDniFormatException
     * @throws InvalidDniLengthException
     * @throws InvalidDniLetterException
     */
    private function __construct(string $dni)
    {
        $this->checkDniLength($dni);
        $this->checkDniStringStructure($dni);
        $this->checkIfDniIsValid($dni);

        $this->dni = $dni;
    }

    /**
     * @param string $dni
     * @throws InvalidDniLengthException
     */
    private function checkDniLength(string $dni): void
    {
        if (strlen($dni) !== self::DNI_LENGTH_TO_CHECK) {
            throw new InvalidDniLengthException();
        }
    }

    /**
     * @param string $dni
     * @throws InvalidDniFormatException
     */
    private function checkDniStringStructure(string $dni): void
    {
        if (!preg_match('/^[XYZ\d]\d{7,7}[^UIOÑ\d]$/u', $dni)) {
            throw new InvalidDniFormatException();
        }
    }

    /**
     * @param string $dni
     * @return Dni
     * @throws InvalidDniFormatException
     * @throws InvalidDniLengthException
     * @throws InvalidDniLetterException
     */
    public static function buildDni(string $dni) : Dni
    {
        return new self($dni);
    }

    public function getDni() : string
    {
        return $this->dni;
    }

    /**
     * @param string $dni
     * @throws InvalidDniLetterException
     */
    private function checkIfDniIsValid(string $dni): void
    {
        $dniNumber = $this->getDniNumber($dni);
        $dniLetter = $this->getDniLetter($dni);
        $remainder = $this->getDniReminder($dniNumber);
        if ($dniLetter !== self::EQUIVALENCES_REMAINDER[$remainder]) {
            throw new InvalidDniLetterException();
        }
    }

    /**
     * @param string $dni
     * @return array|false|string|string[]
     */
    private function getDniNumber(string $dni)
    {
        $dniNumber = substr($dni, 0, -1);
        return str_replace(self::EQUIVALENCE_FIRST_LETTER, self::EQUIVALENCE_FIRST_LETTER_DIGIT, $dniNumber);
    }

    /**
     * @param string $dni
     * @return string
     */
    private function getDniLetter(string $dni): string
    {
        return strtoupper(substr($dni, -1));
    }

    /**
     * @param int $dniNumber
     * @return int
     */
    private function getDniReminder(int $dniNumber): int
    {
        return $dniNumber % self::DNI_DIVISOR;
    }
}