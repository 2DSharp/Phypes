<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\Validator;
use PHPUnit\Framework\TestCase;
use Mockery;

final class PasswordTest extends TestCase
{
    public function testImplementsTypeInterface() : void
    {
        $this->assertInstanceOf(Type::class, $this->getValidPassword('Password!123'));
    }

    /**
     * Check if getValue() returns correctly upon running by a mock validator
     */
    public function testGetValue() : void
    {
        $password = $this->getValidPassword('Password!123');
        $this->assertEquals('Password!123', $password->getValue());
    }

    /**
     * Should throw an InvalidArgumentException on failure to validate.
     */
    public function testExceptionOnFailure() : void
    {
        $failingValue = 'password';

        $validator = Mockery::mock(Validator::class);
        $validator->allows()->isValid($failingValue)->andReturns(false);
        $validator->allows()->getErrorMessage()->andReturns("Some error message that shouldn't matter here");
        $validator->allows()->getErrorCode()->andReturns(000);

        $this->expectException(\InvalidArgumentException::class);

        new Password($failingValue, $validator);
    }

    /**
     * Return a valid Password object passing validation on the mock.
     * @param string $validPassword
     * @return Password
     * @throws \GreenTea\Phypes\Exception\PrematureErrorCallException
     */
    private function getValidPassword(string $validPassword) : Password
    {
        $validator = Mockery::mock(Validator::class);
        $validator->allows()->isValid($validPassword)->andReturns(true);

        return new Password($validPassword, $validator);
    }
}