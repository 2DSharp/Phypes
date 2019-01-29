<?php
declare(strict_types=1);

namespace Phypes\UnitTest\Type;

use Phypes\Error\Error;
use Phypes\Result\Result;
use Phypes\Type\IPAddress;
use Phypes\Type\Type;
use Phypes\Validator\Validator;
use PHPUnit\Framework\TestCase;
use Mockery;

final class IPAddressTest extends TestCase
{
    public function testImplementsTypeInterface() : void
    {
        $this->assertInstanceOf(Type::class, $this->getValidIPAddress('127.0.0.1'));
    }

    /**
     * Check if getValue() returns correctly upon running by a mock validator
     */
    public function testGetValue() : void
    {
        $ip = $this->getValidIPAddress('127.0.0.1');
        $this->assertEquals('127.0.0.1', $ip->getValue());
    }

    /**
     * Should throw an InvalidArgumentException on failure to validate.
     */
    public function testExceptionOnFailure() : void
    {
        $failingValue = "127.0.0";

        $validator = Mockery::mock(Validator::class);
        $result = Mockery::mock(Result::class);
        $error = Mockery::mock(Error::class);

        $validator->allows()->validate($failingValue)->andReturns($result);

        $result->allows()->isValid()->andReturns(false);
        $result->allows()->getFirstError()->andReturns($error);

        $error->allows()->getMessage()->andReturn('Wrong IP address');
        $error->allows()->getCode()->andReturn(222);

        $this->expectException(\InvalidArgumentException::class);

        new IPAddress($failingValue, $validator);
    }

    /**
     * @param string $validIPAddress
     * @return IPAddress
     * @throws \InvalidArgumentException
     */
    private function getValidIPAddress(string $validIPAddress) : IPAddress
    {
        $validator = Mockery::mock(Validator::class);
        $result = Mockery::mock(Result::class);

        $validator->allows()->validate($validIPAddress)->andReturns($result);
        $result->allows()->isValid()->andReturns(true);

        $ip = new IPAddress($validIPAddress, $validator);

        return $ip;
    }
}