<?php
declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Result;

interface Validator
{
    public function validate($type, $options = []) : Result;
}