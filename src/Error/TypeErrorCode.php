<?php  declare(strict_types=1);

namespace Phypes\Error;


abstract class TypeErrorCode
{
    const EMAIL_INVALID = 32001;
    const PASSWORD_INVALID = 32002;
    const IP_INVALID = 32003;
    const NAME_INVALID = 32004;
}