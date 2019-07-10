<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Type;


use Phypes\Exception\InvalidValue;
use Phypes\Result\Failure;
use Phypes\Validator\UsernameValidator;
use Phypes\Validator\Validator;
use function Phypes\getOptionalValue;

class Username implements Type
{
    const OPT_MIN_LEN = 0;
    const OPT_MAX_LEN = 1;
    const OPT_ALLOWED_SPECIAL_CHARS = 2;
    /**
     * @var string $username
     */
    private $username;

    /**
     * Username constructor.
     * @param string $username
     * @param array $options
     * @param Validator|null $validator
     * @throws InvalidValue
     * @throws \Phypes\Exception\InvalidRule
     */
    public function __construct(string $username, $options = [], Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new UsernameValidator(
                getOptionalValue(self::OPT_MIN_LEN, $options, 4),
                getOptionalValue(self::OPT_MAX_LEN, $options, 12),
                getOptionalValue(self::OPT_ALLOWED_SPECIAL_CHARS, $options, ['-', '_']));
        }

        $result = $validator->validate($username, $options);

        if (!$result->isValid()) {
            /**
             * @var Failure $result
             */
            $error = $result->getFirstError();
            throw new InvalidValue($error->getMessage(), $error->getCode());
        }
        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->username;
    }

    public function getValue()
    {
        return $this->username;
    }
}