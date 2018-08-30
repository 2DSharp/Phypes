<?php

namespace GreenTea\Flux;

use GreenTea\Flux\Type\Type;

interface Validator
{
    public function validate($type, $options = []);
}