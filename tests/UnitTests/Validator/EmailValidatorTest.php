<?php
declare(strict_types=1);


namespace GreenTea\Phypes\Validator;

use GreenTea\Phypes\Exception\PrematureErrorCallException;
use PHPUnit\Framework\TestCase;

class EmailValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new EmailValidator();
    }

    public function testImplementsInterface() : void
    {
        $this->assertInstanceOf(Validator::class, $this->validator);
    }

    /**
     * Test passing condition on a valid email
     */
    public function testIsValidPass() : void
    {
        $result = $this->validator->isValid('2d@twodee.me');
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsValidFailure() : void
    {
        $result = $this->validator->isValid('12345lol@');
        $this->assertFalse($result);
        $result = $this->validator->isValid('');
        $this->assertFalse($result);
    }

    /**
     * Check the error message delivered on failure
     */
    public function testErrorMessageReturned() : void
    {
        $this->validator->isValid('invalid email');
        $result = $this->validator->getErrorMessage();

        $this->assertEquals('The provided email is invalid.', $result);
    }

    /**
     * Make sure the error message is null on valid data
     */
    public function testNoErrorMessageOnValidEmail() : void
    {
        $this->validator->isValid('2d@twodee.me');
        $result = $this->validator->getErrorMessage();

        $this->assertNull($result);
    }

    /**
     * Return the error state to empty on successful validation
     */
    public function testWithMultipleValidations() : void
    {
        $this->testErrorMessageReturned();
        $this->testNoErrorMessageOnValidEmail();
    }

    /**
     * Expect an exception to be thrown on calling getErrorMessage() before isValid()
     */
    public function testExceptionOnPrematureErrorRetrieval() : void
    {
        $this->expectException(PrematureErrorCallException::class);
        $this->validator->getErrorMessage();
    }
}
