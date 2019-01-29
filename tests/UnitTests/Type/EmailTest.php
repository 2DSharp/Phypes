<?php declare(strict_types=1);

namespace Phypes\UnitTest\Type;

use Phypes\Error\Error;
use Phypes\Result;
use Phypes\Type\Email;
use Phypes\Type\Type;
use Phypes\Validator\Validator;
use PHPUnit\Framework\TestCase;
use Mockery;

final class EmailTest extends TestCase
{
    public function testImplementsTypeInterface() : void
    {
        $this->assertInstanceOf(Type::class, $this->getValidEmail('email@example.com'));
    }

    /**
     * Check if getValue() returns correctly upon running by a mock validator
     */
    public function testGetValue() : void
    {
        $email = $this->getValidEmail('email@example.com');
        $this->assertEquals('email@example.com', $email->getValue());
    }

    /**
     * Should throw an InvalidArgumentException on failure to validate.
     */
    public function testExceptionOnFailure() : void
    {
        $failingValue = 'john@12.';

        $validator = Mockery::mock(Validator::class);
        $result = Mockery::mock(Result::class);
        $error = Mockery::mock(Error::class);

        $validator->allows()->validate($failingValue)->andReturns($result);
        $result->allows()->isValid()->andReturns(false);
        $result->allows()->getFirstError()->andReturns($error);

        $error->allows()->getMessage()->andReturns('The provided email is invalid.');
        $error->allows()->getCode()->andReturns(111);

        $this->expectException(\InvalidArgumentException::class);
        new Email($failingValue, $validator);
    }

    /**
     * Return a valid email address object passing validation on the mock.
     * @param string $validEmail
     * @return Email
     */
    private function getValidEmail(string $validEmail) : Email
    {
        $validator = Mockery::mock(Validator::class);
        $result = Mockery::mock(Result::class);

        $validator->allows()->validate($validEmail)->andReturns($result);
        $result->allows()->isValid()->andReturns(true);

        $email = new Email($validEmail, $validator);
        return $email;
    }
}