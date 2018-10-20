<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

use PHPUnit\Framework\TestCase;

class UrlValidatorTest extends TestCase
{
    private $validator;

    public function setUp()
    {
        $this->validator = new UrlValidator();
    }

    public function testImplementsInterface() : void
    {
        $this->assertInstanceOf(Validator::class, $this->validator);
    }

    /**
     * Test passing condition on a valid URL
     *
     * @dataProvider correctUrl
     *
     * @param string $url
     */
    public function testIsValidPass(string $url) : void
    {
        $result = $this->validator->isValid($url);
        $this->assertTrue($result);
    }

    /**
     * Should fail and return false
     *
     * @dataProvider wrongUrl
     *
     * @param string $url
     */
    public function testIsValidFailure(string $url) : void
    {
        $result = $this->validator->isValid($url);
        $this->assertFalse($result);
    }

    /**
     * Should fail and return the Invalid URL error code
     */
    public function testErrorCodeOnFailure() : void
    {
        $this->validator->isValid('123312');
        $result = $this->validator->getErrorCode();

        $this->assertEquals(Error::IP_INVALID, $result);
    }

    /**
     * Should pass and return null error code and message.
     */
    public function testErrorOnPass() : void
    {
        $this->validator->isValid('http://google.com');

        $code = $this->validator->getErrorCode();
        $msg = $this->validator->getErrorMessage();

        $this->assertNull($code);
        $this->assertNull($msg);
    }

    /**
     * Should fail and pass. Have the message and code unaffected by a different function call.
     */
    public function testMultipleValidations() : void
    {
        $this->testErrorCodeOnFailure();
        $this->testErrorOnPass();
    }

    public function correctUrl()
    {
        return [
            yield [
                'http://127.0.0.1',
            ],
            yield [
                'https://google.com/',
            ],
            yield [
                'https://www.fb.io/some/path?a=1&b=14',
            ],
            yield [
                '//yahoo.com',
            ],
        ];
    }

    public function wrongUrl()
    {
        return [
            yield [
                'hello world',
            ],
            yield [
                123,
            ],
            yield [
                'abcd://hello.world',
            ],
            yield [
                '',
            ],
        ];
    }
}
