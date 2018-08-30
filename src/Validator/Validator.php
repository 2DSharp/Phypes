<?php

namespace GreenTea\Flux\Validator;

use GreenTea\Flux\Type\Type;

interface Validator
{
    public function validate($type, $options = []);
}