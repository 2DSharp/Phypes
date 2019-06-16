<?php declare(strict_types=1);

namespace Phypes\Type;

use Phypes\Result\Failure;
use Phypes\Validator\PasswordValidator;
use Phypes\Validator\Validator;
use function Phypes\getOptionalValue;

class Password implements Type
{
    const OPT_MIN_LENGTH = 0;
    const OPT_MIN_CHAR_VARIETY = 1;
    /**
     * @var string $password
     */
    private $password;

    /**
     * Create an password object if data is valid.
     * @param string $password
     * @param array $options
     * @param Validator $validator
     * @throws \Phypes\Exception\InvalidAggregateRule
     * @throws \Phypes\Exception\InvalidRuleOption
     */
    public function __construct(string $password, $options =[], Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new PasswordValidator(
                getOptionalValue(self::OPT_MIN_LENGTH, $options, 8),
                getOptionalValue(self::OPT_MIN_CHAR_VARIETY, $options, 2));
        }

        $result = $validator->validate($password);

        if (!$result->isValid()) {
            /**
             * @var Failure $result
             */
            $error = $result->getFirstError();
            throw new \InvalidArgumentException($error->getMessage(), $error->getCode());
        }
        $this->password = $password;
    }

    /**
     * Get string representation of the password object.
     * @return string
     */
    public function __toString(): string
    {
        return $this->password;
    }

    /**
     * Get real value of the password object.
     * @return string
     */
    public function getValue() : string
    {
        return $this->password;
    }
}