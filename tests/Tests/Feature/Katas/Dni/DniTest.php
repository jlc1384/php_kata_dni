<?php

namespace Tests\Feature\Katas\Dni;

use PHPUnit\Framework\TestCase;
use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Integrations\Dni;

class DniTest  extends TestCase
{
    public function test_dni_is_invalid_because_dni_string_is_too_long()
    {
        $this->expectException(InvalidDniLengthException::class);
        $this->expectExceptionMessage('Dni string is too long');
        $dni = "1234567890F";
        new Dni($dni);
    }

    public function test_dni_is_invalid_because_dni_string_is_too_short()
    {
        $this->expectException(InvalidDniLengthException::class);
        $this->expectExceptionMessage('Dni string is too short');
        $dni = "7890F";
        new Dni($dni);
    }
}