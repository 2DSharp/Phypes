<?php declare(strict_types=1);

namespace Phypes\UnitTest\Validator;

use PHPUnit\Framework\TestCase;
use Phypes\Error\TypeErrorCode;
use Phypes\Validator\PasswordValidator;
use Phypes\Validator\Validator;

class PasswordValidatorTest extends TestCase
{
    /**
     * @var PasswordValidator $validator
     */
    private $validator;

    public function setUp()
    {
        $this->validator = new PasswordValidator();
    }

    public function testImplementsInterface() : void
    {
        $this->assertInstanceOf(Validator::class, $this->validator);
    }

    /**
     * Test passing condition on a valid password
     */
    public function testIsValidWithThreeTypesOfCharactersNoSpecialCharacters() : void
    {

        $result = $this->validator->validate('PassWord123');

        $this->assertTrue($result->isValid());
    }

    /**
     * Test passing condition on a valid password
     */
    public function testIsValidWithThreeTypesOfCharactersWithSpecialCharacters() : void
    {
        $result = $this->validator->validate('PassWord^')->isValid();
        $this->assertTrue($result);
    }

    /**
     * Test passing condition on a valid password
     */
    public function testIsValidWithFourTypesOfCharacters() : void
    {
        $result = $this->validator->validate('PassWord^123')->isValid();
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsNotValidWithOneTypeOfCharacters() : void
    {
        $result = $this->validator->validate('password')->isValid();
        $this->assertFalse($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsNotValidWithTwoTypesOfCharacters() : void
    {
        $result = $this->validator->validate('Password')->isValid();
        $this->assertFalse($result);
    }

    /**
     * Should fail and return false
     */
    public function testShortPassword() : void
    {
        $result = $this->validator->validate('Pa!1')->isValid();
        $this->assertFalse($result);
    }

    /**
     * Should pass and return true
     */
    public function test8CharacterPassword() : void
    {
        $result = $this->validator->validate('Pa!1sswo')->isValid();
        $this->assertTrue($result);
    }

    /**
     * Failure type #1: length
     */
    public function testErrorMessageOnLength() : void
    {
        $result = $this->validator->validate('pass');
        $msg = $result->getFirstError()->getMessage();
        $this->assertEquals('The password is not at least 8 characters long', $msg);
    }

    public function testErrorCodeOnLength() : void
    {
        $result = $this->validator->validate('pass');
        $code = $result->getFirstError()->getCode();
        $this->assertEquals(TypeErrorCode::PASSWORD_TOO_SMALL, $code);
    }
    /**
     * Failure type #2: variety
     */
    public function testErrorMessageOnDiversity() : void
    {
        // This test fails with "easypassword1_", is "_" considered a numeric or alphabet?
        $expectation = 'The password does not contain at least 3 of these character types:' .
            ' lower case, upper case, numeric and special characters';

        $result = $this->validator->validate('easypassword');
        $msg = $result->getFirstError()->getMessage();

        $this->assertEquals($expectation, $msg);

        $msg = $this->validator
            ->validate('easypassword1')
            ->getFirstError()
            ->getMessage();


        $this->assertEquals($expectation, $msg);
    }

    public function testErrorCodeOnDiversity() : void
    {
        $expectation = TypeErrorCode::PASSWORD_NOT_MULTI_CHARACTER;

        $code = $this->validator
            ->validate('easypassword')
            ->getFirstError()
            ->getCode();

        $this->assertEquals($expectation, $code);

        $code = $this->validator
            ->validate('easypassword1')
        ->getFirstError()
        ->getCode();

        $this->assertEquals($expectation, $code);
    }
    /**
     * Expecting a null message on no error validation
     */
    public function testValidPasswordErrorOutput() : void
    {
        $error = $this->validator->validate('easypasswordA!')->getFirstError();

        $this->assertNull($error);
    }

    public function testMultipleValidationError() : void
    {
        $this->testErrorMessageOnLength();
        $this->testValidPasswordErrorOutput();

    }

}
