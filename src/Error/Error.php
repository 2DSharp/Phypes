<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 1/23/19
 * Time: 2:31 AM
 */

namespace Phypes\Error;


interface Error
{
    public function getCode() : int;
    public function getMessage() : string;
}