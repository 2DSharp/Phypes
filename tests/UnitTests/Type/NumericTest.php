<?php
namespace GreenTea\Phypes\Type;

use PHPUnit\Framework\TestCase;
use GreenTea\Phypes\Type\Numeric;

/**
 * Tests for Type\Numeric class.
 * @author Mangopeaches <https://github.com/mangopeaches>
 */
final class NumericTest extends TestCase
{
    /**
     * Ensures accessor is working.
     *
     * @return void
     */
    public function testGetValue()
    {
        $value = '3.14';
        $number = new Numeric($value);
        $this->assertEquals($value, $number->getValue());
    }

    /**
     * Tests number validates successfully.
     *
     * @return void
     */
    public function testValidateSuccess()
    {
        $number = new Numeric(3.14);
        $this->assertTrue($number->isValid());
        $this->assertEquals('', $number->getError());
    }

    /**
     * Tests invalid number validates successfully.
     *
     * @return void
     */
    public function testValidateFailure()
    {
        $number = new Numeric('test@test');
        $this->assertFalse($number->isValid());
        $this->assertNotEmpty($number->getError());
    }
}