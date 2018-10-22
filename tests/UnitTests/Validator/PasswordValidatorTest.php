<?php
declare(strict_types=1);

namespace Phypes\UnitTest\Validator;

use Phypes\Exception\PrematureErrorCallException;
use PHPUnit\Framework\TestCase;
use Phypes\Validator\Error;
use Phypes\Validator\PasswordValidator;
use Phypes\Validator\Validator;

class PasswordValidatorTest extends TestCase
{
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
        $result = $this->validator->isValid('PassWord123');
        $this->assertTrue($result);
    }

    /**
     * Test passing condition on a valid password
     */
    public function testIsValidWithThreeTypesOfCharactersWithSpecialCharacters() : void
    {
        $result = $this->validator->isValid('PassWord^');
        $this->assertTrue($result);
    }

    /**
     * Test passing condition on a valid password
     */
    public function testIsValidWithFourTypesOfCharacters() : void
    {
        $result = $this->validator->isValid('PassWord^123');
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsNotValidWithOneTypesOfCharacters() : void
    {
        $result = $this->validator->isValid('password');
        $this->assertFalse($result);
    }

    /**
     * Should fail and return false
     */
    public function testIsNotValidWithTwoTypesOfCharacters() : void
    {
        $result = $this->validator->isValid('Password');
        $this->assertFalse($result);
    }

    /**
     * Should fail and return false
     */
    public function testShortPassword() : void
    {
        $result = $this->validator->isValid('Pa!1');
        $this->assertFalse($result);
    }

    /**
     * Should pass and return true
     */
    public function test8CharacterPassword() : void
    {
        $result = $this->validator->isValid('Pa!1sswo');
        $this->assertTrue($result);
    }

    /**
     * Failure type #1: length
     */
    public function testErrorMessageOnLength() : void
    {
        $this->validator->isValid('pass');
        $result = $this->validator->getErrorMessage();
        $this->assertEquals('The password is not at least 8 characters long', $result);
    }

    public function testErrorCodeOnLength() : void
    {
        $this->validator->isValid('pass');
        $result = $this->validator->getErrorCode();
        $this->assertEquals(Error::PASSWORD_TOO_SMALL, $result);
    }
    /**
     * Failure type #2: variety
     */
    public function testErrorMessageOnDiversity() : void
    {
        // This test fails with "easypassword1_", is "_" considered a numeric or alphabet?
        $expectation = 'The password does not contain at least 3 of these character types:' .
            ' lower case, upper case, numeric and special characters';

        $this->validator->isValid('easypassword');
        $result = $this->validator->getErrorMessage();

        $this->assertEquals($expectation, $result);

        $this->validator->isValid('easypassword1');
        $result = $this->validator->getErrorMessage();

        $this->assertEquals($expectation, $result);
    }

    public function testErrorCodeOnDiversity() : void
    {
        $expectation = Error::PASSWORD_NOT_MULTI_CHARACTER;

        $this->validator->isValid('easypassword');
        $result = $this->validator->getErrorCode();

        $this->assertEquals($expectation, $result);

        $this->validator->isValid('easypassword1');
        $result = $this->validator->getErrorCode();

        $this->assertEquals($expectation, $result);
    }
    /**
     * Expecting a null message on no error validation
     */
    public function testValidPasswordErrorOutput() : void
    {
        $this->validator->isValid('easypasswordA!');

        $errorMsg = $this->validator->getErrorMessage();
        $errorCode = $this->validator->getErrorMessage();

        $this->assertNull($errorCode);
        $this->assertNull($errorMsg);
    }

    public function testMultipleValidationError() : void
    {
        $this->testErrorMessageOnLength();
        $this->testValidPasswordErrorOutput();

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
