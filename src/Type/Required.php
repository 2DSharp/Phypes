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

class Required implements Type
{
    /**
     * @var Type $type
     */
    private $type;
    /**
     * Required constructor.
     * @param Type $type
     * @throws EmptyRequiredValue
     */
    public function __construct(Type $type)
    {
        if (empty($type->getValue()))
            throw new EmptyRequiredValue('The required type '. get_class($type) . ' cannot have an empty value');

        $this->type = $type;
    }

    public function __toString(): string
    {
    }

    public function getValue()
    {
        return $this->type->getValue();
    }
}