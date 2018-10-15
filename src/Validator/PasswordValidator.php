<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;


class PasswordValidator implements Validator
{
    public function isValid($password, $options = []): bool
    {
        $differentCharacterTypes = 0;

        if (preg_match('/[a-z]/', $password)) {
            $differentCharacterTypes++;
        }

        if (preg_match('/[A-Z]/', $password)) {
            $differentCharacterTypes++;
        }

        //Check for numbers
        if (preg_match('/[\d]/', $password)) {
            $differentCharacterTypes++;
        }

        //Check for anything that's not a word aka special characters
        if (preg_match('/[\W]/', $password)) {
            $differentCharacterTypes++;
        }

        return $differentCharacterTypes > 2;
    }
}