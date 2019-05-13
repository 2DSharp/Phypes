<?php declare(strict_types=1);

namespace Phypes\UnitTest\Validator;

use Phypes\Error\TypeErrorCode;
use PHPUnit\Framework\TestCase;
use Phypes\Result\Success;
use Phypes\Validator\EmailValidator;
use Phypes\Validator\Validator;

class EmailValidatorTest extends TestCase
{
    /**
     * @var Validator $validator
     */
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
        $result = $this->validator->validate('2d@twodee.me')->isValid();
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsValidFailure() : void
    {
        $result = $this->validator->validate('12345lol@')->isValid();
        $this->assertFalse($result);

        $result = $this->validator->validate('')->isValid();
        $this->assertFalse($result);
    }

    /**
     * Check the error message delivered on failure
     */
    public function testErrorMessageReturned() : void
    {
        $result = $this->validator->validate('invalid email');
        $msg = $result->getFirstError()->getMessage();

        $this->assertEquals('The provided email is invalid.', $msg);
    }

    public function testErrorCodeReturned() : void
    {
        $result = $this->validator->validate('invalid email');
        $code = $result->getFirstError()->getCode();

        $this->assertEquals(TypeErrorCode::EMAIL_INVALID, $code);
    }

    /**
     * Make sure the Error instance is null on valid data
     */
    public function testNoErrorOnValidEmail() : void
    {
        $result = $this->validator->validate('2d@twodee.me');

        self::assertInstanceOf(Success::class, $result);
    }

}
