<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 1/21/19
 * Time: 12:48 PM
 */

namespace Phypes\Rule;


interface Rule
{
    public function validate($data);
}