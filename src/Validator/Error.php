<?php
/**
 * Created by PhpStorm.
 * User: dedipyaman
 * Date: 10/18/18
 * Time: 1:15 AM
 */

namespace Phypes\Validator;


abstract class Error
{
    const PREMATURE_CALL_TO_METHOD  = 230000;

    const EMAIL_INVALID = 320001;
    const PASSWORD_TOO_SMALL = 320002;
    const PASSWORD_NOT_MULTI_CHARACTER = 32003;
    const IP_INVALID = 32004;
}