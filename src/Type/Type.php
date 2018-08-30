<?php

namespace GreenTea\Flux\Type;

use GreenTea\Flux\Validator\Validator;

interface Type
{
    /**
     * Instantiate the Flux data type
     * @param Validator $validator : A validator implementing the Validator interface
     */
    public function __construct($value, Validator $validator);
    public function __toString() : string;
    public function getValue();
}




