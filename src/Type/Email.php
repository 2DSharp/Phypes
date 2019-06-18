<?php declare(strict_types=1);

namespace Phypes\Type;

use Phypes\Exception\InvalidValue;
use Phypes\Result\Failure;
use Phypes\Validator\EmailValidator;
use Phypes\Validator\Validator;

class Email implements Type
{
    /**
     * @var string $email
     */
    private $email;

    /**
     * Create an email object if data is valid.
     * @param string $email
     * @param Validator $validator
     * @throws InvalidValue
     */
    public function __construct(string $email, Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new EmailValidator();
        }
        $result = $validator->validate($email);

        if (!$result->isValid()) {
            /**
             * @var Failure $result
             */
            throw new InvalidValue($result->getFirstError()->getMessage(), $result->getErrors());
        }
        $this->email = $email;
    }

    /**
     * Get string representation of the email object.
     * @return string
     */
    public function __toString(): string
    {
        return $this->email;
    }

    /**
     * Get real value of the email object.
     * @return string
     */
    public function getValue() : string
    {
        return $this->email;
    }
}