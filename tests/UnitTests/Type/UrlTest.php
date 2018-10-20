<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Validator\Validator;
use PHPUnit\Framework\TestCase;
use Mockery;

final class UrlTest extends TestCase
{
    public function testImplementsTypeInterface() : void
    {
        $this->assertInstanceOf(Type::class, $this->getValidUrl('http://google.com'));
    }

    /**
     * Check if getValue() returns correctly upon running by a mock validator
     */
    public function testGetValue() : void
    {
        $url = $this->getValidUrl('http://google.com');
        $this->assertEquals('http://google.com', $url->getValue());
    }

    /**
     * Should throw an InvalidArgumentException on failure to validate.
     */
    public function testExceptionOnFailure() : void
    {
        $failingValue = 'http://google.com';

        $validator = Mockery::mock(Validator::class);
        $validator->allows()->isValid($failingValue)->andReturns(false);
        $validator->allows()->getErrorMessage()->andReturns('Invalid URL');
        $validator->allows()->getErrorCode()->andReturn(222);

        $this->expectException(\InvalidArgumentException::class);

        new Url($failingValue, $validator);
    }

    /**
     * Return a valid URL object passing validation on the mock.
     * @param string $validUrl
     * @return Url
     * @throws \GreenTea\Phypes\Exception\PrematureErrorCallException
     */
    private function getValidUrl(string $validUrl) : Url
    {
        $validator = Mockery::mock(Validator::class);
        $validator->allows()->isValid($validUrl)->andReturns(true);

        return new Url($validUrl, $validator);
    }
}
