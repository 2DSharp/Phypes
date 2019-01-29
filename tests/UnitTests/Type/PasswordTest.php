<?php declare(strict_types=1);

namespace Phypes\UnitTest\Type;

use Phypes\Error\Error;
use Phypes\Result\Result;
use Phypes\Type\Password;
use Phypes\Type\Type;
use Phypes\Validator\Validator;
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
        $result = Mockery::mock(Result::class);
        $error = Mockery::mock(Error::class);

        $validator->allows()->validate($failingValue)->andReturns($result);

        $result->allows()->isValid()->andReturns(false);
        $result->allows()->getFirstError()->andReturns($error);

        $error->allows()->getMessage()->andReturns("Some error message that shouldn't matter here");
        $error->allows()->getCode()->andReturns(000);

        $this->expectException(\InvalidArgumentException::class);

        new Password($failingValue, $validator);
    }

    /**
     * Return a valid Password object passing validation on the mock.
     * @param string $validPassword
     * @return Password
     */
    private function getValidPassword(string $validPassword) : Password
    {
        $validator = Mockery::mock(Validator::class);
        $result = Mockery::mock(Result::class);

        $validator->allows()->validate($validPassword)->andReturns($result);
        $result->allows()->isValid()->andReturns(true);
        return new Password($validPassword, $validator);
    }
}