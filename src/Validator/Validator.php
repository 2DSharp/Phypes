<?php

namespace GreenTea\Phypes\Validator;

use GreenTea\Phypes\Type\Type;

interface Validator
{
    public function validate($type, $options = []) : bool;
}