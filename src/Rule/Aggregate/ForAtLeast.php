<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Rule\Aggregate;


use Phypes\Error\Error;
use Phypes\Exception\InvalidAggregateRule;
use Phypes\Result\Failure;
use Phypes\Result\Result;
use Phypes\Result\Success;
use Phypes\Rule\Rule;

/**
 * Class ForAtLeast
 * @package Phypes\Rule\Aggregate
 * @author Dedipyaman Das <2d@twodee.me>
 *
 * Rule to aggregate different rules and validity depends on passing at least the number of specified rules out of all.
 */
class ForAtLeast implements Rule
{
    /**
     * @var int $minimum
     */
    private $minimum;
    /**
     * @var array|Rule[] $rules
     */
    private $rules = [];
    /**
     * ForAtLeast constructor.
     * @param int $numOfRules
     * @param Rule ...$rules
     * @throws InvalidAggregateRule
     */
    public function __construct(int $numOfRules, Rule... $rules)
    {
        if (empty($rules))
            throw new InvalidAggregateRule("No rules specified for aggregate rule", ForAtLeast::class);

        if (count($rules) < $numOfRules)
            throw new InvalidAggregateRule('Minimum passing rule number is greater than supplied rules',
                ForAtLeast::class);

        $this->rules = $rules;
        $this->minimum = $numOfRules;
    }

    public function validate($data): Result
    {
        /**
         * @var array|Error[] $errors
         */
        $errors = [];
        $passed = 0;

        foreach ($this->rules as $rule) {
            $result = $rule->validate($data);

            if (!$result->isValid()) {
                /**
                 * @var Failure $result
                 * @var Error $error
                 */
                foreach ($result->getErrors() as $error) {
                    $errors[] = $error;
                }
            }
            else {
                $passed++;
            }

            if ($passed >= $this->minimum)
                return new Success();
        }
        return new Failure(...$errors);
    }
}