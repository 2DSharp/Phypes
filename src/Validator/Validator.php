<?php

namespace GreenTea\Flux;

use GreenTea\Flux\Type\Type;

interface Validator
{
    public function validate(Type $type, $options = []);
}