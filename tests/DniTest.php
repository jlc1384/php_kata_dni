<?php

namespace Tests\Feature\Katas\Dni;

use PHPUnit\Framework\TestCase;

class DniTest  extends TestCase
{
    public function test_dni_is_invalid_because_the_string_is_too_long()
    {
        $this->expectException(InvalidDniLengthException::class);
        $this->expectExceptionMessage('Dni string is too short');
        $dniObj = new Dni();
    }
}