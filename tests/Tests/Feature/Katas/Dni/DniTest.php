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
        $dni = "1234567890F";
        new Dni($dni);
    }

    public function test_dni_is_invalid_because_dni_string_is_too_short()
    {
        $this->expectException(InvalidDniLengthException::class);
        $dni = "7890F";
        new Dni($dni);
    }

    public function test_dni_is_invalid_because_last_character_is_a_number()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dni = "123456789";
        new Dni($dni);
    }

    public function test_dni_is_invalid_because_last_character_cannot_be_i_u_o_spanish_n()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dni = "12345678I";
        new Dni($dni);
    }

    public function test_dni_is_invalid_because_it_has_characters_in_the_middle()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dni = "123JSA78S";
        new Dni($dni);
    }

    public function test_dni_is_invalid_because_the_beginning_of_the_string_is_not_a_number_x_y_or_z()
    {
        $this->expectException(InvalidDniFormatException::class);
        $dni = "L2345678S";
        new Dni($dni);
    }
}