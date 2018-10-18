<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Type;

use GreenTea\Phypes\Type\Type;
use GreenTea\Phypes\Validator\EmailValidator;
use GreenTea\Phypes\Validator\Validator;

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
     * @throws \InvalidArgumentException
     * @throws \GreenTea\Phypes\Exception\PrematureErrorCallException
     */
    public function __construct(string $email, Validator $validator = null)
    {
        if ($validator == null) {
            // use the default validator
            $validator = new EmailValidator();
        }

        if (!$validator->isValid($email)) {
            throw new \InvalidArgumentException($validator->getErrorMessage(), $validator->getErrorCode());
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