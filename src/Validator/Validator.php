<?php
declare(strict_types=1);

namespace GreenTea\Phypes\Validator;

interface Validator
{
    public function isValid($type, $options = []) : bool;
    public function getErrorMessage(): ?string;
}