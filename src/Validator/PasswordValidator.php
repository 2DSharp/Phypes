<?php declare(strict_types=1);

namespace Phypes\Validator;

use Phypes\Error\TypeError;
use Phypes\Error\TypeErrorCode;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Aggregate\ForAll;
use Phypes\Rule\Aggregate\ForAtLeast;
use Phypes\Rule\Pattern\ContainsPattern;
use Phypes\Rule\String\MinimumLength;
use Phypes\Rule\String\TextCase;

class PasswordValidator implements Validator
{
    /**
     * Validate the password based on different imposing conditions
     * Implement your own password validator if you want a more custom set of rules
     * This set of rules should work for a lot of general use cases
     * @param $password
     * @return Result
     * @throws \Phypes\Exception\InvalidRuleOption
     * @throws \Phypes\Exception\InvalidAggregateRule
     */
    public function validate($password): Result
    {
        $atleast = new ForAtLeast(2,
            new ContainsPattern(ContainsPattern::UPPERCASE),
            new ContainsPattern(ContainsPattern::LOWERCASE),
            new ContainsPattern(ContainsPattern::SPECIAL_CHARS),
            new ContainsPattern(ContainsPattern::NUMBER)
        );

        $rule = new ForAll(
            $atleast,
            new MinimumLength(8));

        $result = $rule->validate($password);

        if ($result->isValid())
            return new Success();
        /**
         * @var Failure $result
         */
        return new Failure(new TypeError(TypeErrorCode::PASSWORD_INVALID, 'Invalid password'),
            ...$result->getErrors());
    }
}