<?php declare(strict_types=1);

namespace Phypes\UnitTest\Validator;

use PHPUnit\Framework\TestCase;
use Phypes\Error\TypeErrorCode;
use Phypes\Result\Success;
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
    public function testIsValidWithTwoTypesOfCharacters() : void
    {
        $result = $this->validator->validate('Password')->isValid();
        $this->assertTrue($result);
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
     * Expecting an instance of Success::class on success
     */
    public function testValidPasswordErrorOutput() : void
    {
        $result = $this->validator->validate('easypasswordA!');
        $this->assertInstanceOf(Success::class, $result);
    }

}
