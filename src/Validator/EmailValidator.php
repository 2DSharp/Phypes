<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 9/4/18
 * Time: 11:10 PM
 */

namespace GreenTea\Phypes\Validator;


class EmailValidator implements Validator
{
    public function isValid($email, $options = []): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}