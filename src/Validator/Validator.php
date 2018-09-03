<?php

namespace GreenTea\Phypes\Validator;

interface Validator
{
    public function validate($type, $options = []) : bool;
}