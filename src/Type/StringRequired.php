<?php
/*
 * This file is part of Skletter <https://github.com/2DSharp/Skletter>.
 *
 * (c) Dedipyaman Das <2d@twodee.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Phypes\Type;


use Phypes\Exception\EmptyRequiredValue;

class StringRequired implements Type
{
    /**
     * @var string $value
     */
    private $value;

    /**
     * Required constructor.
     * @param string $text
     * @throws EmptyRequiredValue
     */
    public function __construct(?string $text)
    {
        if (empty($text))
            throw new EmptyRequiredValue();

        $this->value = $text;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function getValue()
    {
        return $this->value;
    }
}