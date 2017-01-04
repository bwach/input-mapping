<?php

namespace InputMapping\Mapping;

use InputMapping\Enum\XEnum;
use InputMapping\Exception\ImproperInputException;
use InputMapping\Model\Input;

/**
 * {@inheritdoc}
 *
 * Replaces
 *
 * A && B && !C => X = S
 *
 * with
 *
 * A && B && !C => X = T
 *
 * and adds
 *
 * A && !B && C => X = S
 *
 *
 */
class Specialized2Mapping extends BaseMapping
{

    /**
     * {@inheritdoc}
     */
    protected function calculateX(Input $input)
    {
        $X = null;

        $A = $input->getA();
        $B = $input->getB();
        $C = $input->getC();

        if ($A + $B + $C < 2) {
            throw new ImproperInputException();
        }

        /**
         * A && B && !C => X = T
         * A && B && C => X = R
         * !A && B && C => X = T
         * A && !B && C => X = S
         */
        if ($A && $B && !$C) {
            $X = XEnum::T;
        } elseif ($A && $B && $C) {
            $X = XEnum::R;
        } elseif (!$A && $B && $C) {
            $X = XEnum::T;
        } elseif ($A && !$B && $C) {
            $X = XEnum::S;
        }

        return $X;
    }

    /**
     * Replaces base formula for Y when X = S with
     *
     *  X = S => Y = F + D + (D * E / 100)
     *
     * @param $D
     * @param $E
     * @param $F
     * @return int
     */
    protected function YForXEqualsSFormula($D, $E, $F)
    {
        return $F + $D + ($D * $E / 100);
    }
}
