<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 8/31/18
 * Time: 1:26 AM
 */

namespace GreenTea\Phypes\Type;

use PHPUnit\Framework\TestCase;
use GreenTea\Phypes\Type\Email;

/**
 * Tests for Type\Email class.
 */
final class EmailTest extends TestCase
{
    /**
     * Ensures accessor is working.
     *
     * @return void
     */
    public function testGetValue()
    {
        $value = 'test@test.com';
        $email = new Email($value);
        $this->assertEquals($value, $email->getValue());
    }

    /**
     * Tests email validates successfully.
     *
     * @return void
     */
    public function testValidateSuccess()
    {
        $email = new Email('test@test.com');
        $this->assertTrue($email->isValid());
        $this->assertEquals('', $email->getError());
    }

    /**
     * Tests invalid email validates successfully.
     *
     * @return void
     */
    public function testValidateFailure()
    {
        $email = new Email('test@test');
        $this->assertFalse($email->isValid());
        $this->assertNotEmpty($email->getError());
    }
}