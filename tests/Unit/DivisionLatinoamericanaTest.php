<?php

use PHPUnit\Framework\TestCase;
require_once __DIR__ . '/../../app/Services/DivisionLatinoamericana.php';

class DivisionLatinoamericanaTest extends TestCase
{
    public function testDivisionSimple()
    {
        $resultado = DivisionLatinoamericana::resolver('456', 4);
        $this->assertEquals('114', $resultado['cociente']);
        $this->assertEquals(0, $resultado['residuo']);
        $this->assertCount(3, $resultado['steps']);
    }

    public function testDivisionConCerosEnCociente()
    {
        $resultado = DivisionLatinoamericana::resolver('1002', 9);
        $this->assertEquals('111', $resultado['cociente']);
        $this->assertEquals(3, $resultado['residuo']);
        $this->assertTrue(
            array_reduce($resultado['steps'], function($carry, $step) {
                return $carry || $step['quotientDigit'] === 0;
            }, false),
            'Debe haber al menos un cero en el cociente.'
        );
    }

    public function testDivisionGrande()
    {
        $resultado = DivisionLatinoamericana::resolver('987654', 23);
        $this->assertEquals((string)intdiv(987654,23), $resultado['cociente']);
        $this->assertEquals(987654 % 23, $resultado['residuo']);
    }

    public function testDivisionInvalida()
    {
        $this->expectException(InvalidArgumentException::class);
        DivisionLatinoamericana::resolver('23', 23);
    }
}
