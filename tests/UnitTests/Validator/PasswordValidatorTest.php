<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

use PHPUnit\Framework\TestCase;

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
}
