<?php
declare(strict_types=1);


namespace Phypes\UnitTest\Validator;

use Phypes\Exception\PrematureErrorCallException;
use PHPUnit\Framework\TestCase;
use Phypes\Validator\EmailValidator;
use Phypes\Validator\Error;
use Phypes\Validator\Validator;

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

    public function testErrorCodeReturned() : void
    {
        $this->validator->isValid('invalid email');
        $result = $this->validator->getErrorCode();

        $this->assertEquals(Error::EMAIL_INVALID, $result);
    }

    /**
     * Make sure the error message is null on valid data
     */
    public function testNoErrorOnValidEmail() : void
    {
        $this->validator->isValid('2d@twodee.me');
        $msg = $this->validator->getErrorMessage();
        $code = $this->validator->getErrorCode();

        $this->assertNull($msg);
        $this->assertNull($code);

    }

    /**
     * Return the error state to empty on successful validation
     */
    public function testWithMultipleValidations() : void
    {
        $this->testErrorMessageReturned();
        $this->testNoErrorOnValidEmail();
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
