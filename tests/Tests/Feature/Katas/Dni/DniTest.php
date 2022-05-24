<?php

namespace Tests\Feature\Katas\Dni;

use PHPUnit\Framework\TestCase;
use App\Dni\Exceptions\InvalidDniLengthException;
use App\Dni\Exceptions\InvalidDniFormatException;
use App\Dni\Integrations\Dni;

class DniTest  extends TestCase
{
    public function test_dni_is_invalid_because_dni_string_is_too_long()
    {
        $this->expectException(InvalidDniLengthException::class);
        $dniString = "1234567890F";
        Dni::buildDni($dniString);
    }

    public function test_dni_is_invalid_because_dni_string_is_too_short()
    {
        $this->expectException(InvalidDniLengthException::class);
        $dniString = "7890F";
        Dni::buildDni($dniString);
    }

    public function test_dni_is_invalid_because_last_character_is_a_number()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dniString = "123456789";
        Dni::buildDni($dniString);
    }

    public function test_dni_is_invalid_because_last_character_cannot_be_i_u_o_spanish_n()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dniString = "12345678I";
        Dni::buildDni($dniString);
    }

    public function test_dni_is_invalid_because_it_has_characters_in_the_middle()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dniString = "123JSA78S";
        Dni::buildDni($dniString);
    }

    public function test_dni_is_invalid_because_the_beginning_of_the_string_is_not_a_number_x_y_or_z()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dniString = "L2345678S";
        Dni::buildDni($dniString);
    }

    /**
     * @dataProvider validDniDataProvider
     */
    public function test_all_table_possibilities_dni_is_valid($dniExpected)
    {
        $dni = Dni::buildDni($dniExpected);
        $this->assertEquals((string) $dniExpected, $dni);
    }

    public function validDniDataProvider(): array
    {
        return [
            ['00000000T'],
            ['00000001R'],
            ['00000002W'],
            ['00000003A'],
            ['00000004G'],
            ['00000005M'],
            ['00000006Y'],
            ['00000007F'],
            ['00000008P'],
            ['00000009D'],
            ['00000010X'],
            ['00000011B'],
            ['00000012N'],
            ['00000013J'],
            ['00000014Z'],
            ['00000015S'],
            ['00000016Q'],
            ['00000017V'],
            ['00000018H'],
            ['00000019L'],
            ['00000020C'],
            ['00000021K'],
            ['00000022E'],
            ['X0000000T'],
            ['Y0000000Z'],
            ['Z0000000M'],
        ];
    }
}