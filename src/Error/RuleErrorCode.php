<?php declare(strict_types=1);

namespace Phypes\Error;


abstract class RuleErrorCode
{
    const LENGTH_ERROR = 420001;
    const NOT_ALNUM = 420003;
    const CASING_MISMATCH = 420004;
    const NOT_ALPHA = 420005;
    const PATTERN_MISMATCH = 420006;
    const NOT_NUMERIC = 420007;
    const NOT_INTEGER = 420008;
    const NOT_FLOAT = 420009;
    const NOT_POSITIVE = 420010;
    const NOT_NEGATIVE = 420011;
    const EXCEEDS_MAXIMUM = 420012;
    const LESS_THAN_MINIMUM = 420013;
}