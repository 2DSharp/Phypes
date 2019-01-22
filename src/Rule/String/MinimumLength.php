<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 1/23/19
 * Time: 1:53 AM
 */

namespace Phypes\Rule;


class MinimumLength implements Rule
{
    private $minLength;

    public function __construct(int $minLength)
    {
        $this->minLength = $minLength;
    }

    public function validate($data)
    {
        if (mb_strlen($data, 'UTF-8') < $this->minLength) {
            return new Success();
        }
    }
}