<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 8/31/18
 * Time: 1:17 AM
 */

namespace GreenTea\Flux\Type;

use GreenTea\Phypes\Type\Type;
use GreenTea\Phypes\Validator\Validator;

class Email implements Type
{
    /**
     * @var string $email
     */
    private $email;

    /**
     * Email constructor.
     * @param string $email
     * @param Validator $validator
     */
    public function __construct(string $email, Validator $validator)
    {
        $validator->validate($email);
        $this->email = $email;
    }

    public function __toString(): string
    {
        // TODO: Implement __toString() method.
    }

    public function getValue()
    {
        // TODO: Implement getValue() method.
    }
}