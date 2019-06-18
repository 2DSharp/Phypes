<?php
/*
 * This file is part of Phypes <https://github.com/2DSharp/Phypes>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Phypes\Exception;

final class InvalidRuleOption extends InvalidRule
{
    public function __construct(int $option, string $ruleClass)
    {
        parent::__construct($ruleClass . ': Rule option \"' . $option . '\" not defined');
    }
}