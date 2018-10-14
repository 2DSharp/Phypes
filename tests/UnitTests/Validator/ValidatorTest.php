<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 9/4/18
 * Time: 11:56 PM
 */

namespace GreenTea\Phypes\Validator;

use PHPUnit\Framework\TestCase;
use GreenTea\Phypes\Validator\Validator;
use GreenTea\Phypes\Type\Email;
use GreenTea\Phypes\Type\Numeric;

/**
 * Verifies the Validator class works as expected.
 * @author Mangopeaches <https://github.com/mangopeaches>
 */
class ValidatorTest extends TestCase
{
    /**
     * Tests single Email validation works as expected.
     *
     * @return void
     */
    public function testSingleEmailValid()
    {
        $email = new Email('test@test.com');
        $validator = new Validator($email);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    /**
     * Tests multiple Email validation works as expected.
     *
     * @return void
     */
    public function testMultipleEmailValid()
    {
        $types  = [
            new Email('test@test.com'),
            new Email('tester@tester.com')
        ];
        $validator = new Validator($types);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    /**
     * Tests single email validation fails as expected.
     *
     * @return void
     */
    public function testSingleEmailInvalid()
    {
        $email = new Email('test@test');
        $validator = new Validator($email);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
        $this->assertEquals(1, count($validator->errors()));
    }

    /**
     * Tests multiple Email validation fails as expected.
     *
     * @return void
     */
    public function testMultipleEmailInvalid()
    {
        $types  = [
            new Email('test@test'),
            new Email('tester@tester')
        ];
        $validator = new Validator($types);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
        $this->assertEquals(2, count($validator->errors()));
    }

    /**
     * Tests single Numeric validation works as expected.
     *
     * @return void
     */
    public function testNumberEmailValid()
    {
        $number = new Numeric(3.14);
        $validator = new Validator($number);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    /**
     * Tests multiple Numeric validation works as expected.
     *
     * @return void
     */
    public function testMultipleNumberValid()
    {
        $types  = [
            new Numeric(3.14),
            new Numeric(567)
        ];
        $validator = new Validator($types);
        $this->assertTrue($validator->validate());
        $this->assertEmpty($validator->errors());
    }

    /**
     * Tests single Numeric validation fails as expected.
     *
     * @return void
     */
    public function testSingleNumericInvalid()
    {
        $number = new Numeric('test');
        $validator = new Validator($number);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
        $this->assertEquals(1, count($validator->errors()));
    }

    /**
     * Tests multiple Numeric validation fails as expected.
     *
     * @return void
     */
    public function testMultipleNumericInvalid()
    {
        $types  = [
            new Numeric('not a number'),
            new Numeric(null)
        ];
        $validator = new Validator($types);
        $this->assertFalse($validator->validate());
        $this->assertNotEmpty($validator->errors());
        $this->assertEquals(2, count($validator->errors()));
    }
}
