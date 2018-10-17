<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\Validator;
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
        $validator->allows()->isValid($failingValue)->andReturns(false);
        $validator->allows()->getErrorMessage()->andReturns('The provided email is invalid.');
        $validator->allows()->getErrorCode()->andReturns(111);

        $this->expectException(\InvalidArgumentException::class);
        new Email($failingValue, $validator);
    }

    /**
     * Return a valid email address object passing validation on the mock.
     * @param string $validEmail
     * @return Email
     * @throws \GreenTea\Phypes\Exception\PrematureErrorCallException
     */
    private function getValidEmail(string $validEmail) : Email
    {
        $validator = Mockery::mock(Validator::class);
        $validator->allows()->isValid($validEmail)->andReturns(true);

        $email = new Email($validEmail, $validator);
        return $email;
    }
}