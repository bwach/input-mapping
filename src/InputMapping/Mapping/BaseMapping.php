<?php

namespace InputMapping\Mapping;

use InputMapping\Enum\XEnum;
use InputMapping\Exception\ImproperInputException;
use InputMapping\Model\Input;

/**
 * Handle mapping of input data according to set of rules rules
 *
 * A && B && !C => X = S
 * A && B && C => X = R
 * !A && B && C => X =T
 * [other] => [error]
 * X = S => Y = D + (D * E / 100)
 * X = R => Y = D + (D * (E - F) / 100)
 * X = T => Y = D - (D * F / 100)
 *
 */
class BaseMapping
{
    public function calculate(Input $input)
    {
        $X = $this->calculateX($input);
        $Y = $this->calculateY($input, $X);

        return new MappingResult($X, $Y);
    }

    /**
     * Calculates X for result
     *
     * @param Input $input
     * @return string
     * @throws ImproperInputException
     */
    protected function calculateX(Input $input)
    {
        $X = null;

        $A = $input->getA();
        $B = $input->getB();
        $C = $input->getC();

        if ($A + $B + $C < 2 || ($A && !$B && $C)) {
            throw new ImproperInputException();
        }

        /**
         * A && B && !C => X = S
         * A && B && C => X = R
         * !A && B && C => X =T
         */
        if ($A && $B && !$C) {
            $X = XEnum::S;
            return $X;
        } elseif ($A && $B && $C) {
            $X = XEnum::R;
            return $X;
        } elseif (!$A && $B && $C) {
            $X = XEnum::T;
            return $X;
        }

        return $X;
    }

    /**
     * Calculates Y for result
     *
     * @param Input $input
     * @param $X
     * @return mixed
     */
    protected function calculateY(Input $input, $X)
    {
        $Y = null;

        $D = $input->getD();
        $E = $input->getE();
        $F = $input->getF();

        /**
         * X = S => Y = D + (D * E / 100)
         * X = R => Y = D + (D * (E - F) / 100)
         * X = T => Y = D - (D * F / 100)
         */
        switch ($X) {
            case XEnum::S:
                $Y = $this->YForXEqualsSFormula($D, $E, $F);
                break;
            case XEnum::R:
                $Y = $this->YForXEqualsRFormula($D, $E, $F);
                break;
            case XEnum::T:
                $Y = $D - ($D * $F / 100);
                break;
        }

        return $Y;
    }

    /**
     * Calculates formula for Y when X = R
     *
     * X = S => Y = D + (D * E / 100)
     *
     * @param $D
     * @param $E
     * @return mixed
     */
    protected function YForXEqualsSFormula($D, $E, $F)
    {
        return $D + ($D * $E / 100);
    }

    /**
     * Calculates formula for Y when X = R
     *
     * X = R => Y = D + (D * (E - F) / 100)
     *
     * @param $D
     * @param $E
     * @param $F
     * @return mixed
     */
    protected function YForXEqualsRFormula($D, $E, $F)
    {
        return $D + ($D * ($E - $F) / 100);
    }
}
