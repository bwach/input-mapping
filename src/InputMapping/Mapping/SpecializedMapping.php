<?php

namespace InputMapping\Mapping;

/**
 * {@inheritdoc}
 *
 * Replaces base formula for Y when X = R with
 *
 *  X = R => Y = 2D + (D * E / 100)
 */
class SpecializedMapping extends BaseMapping
{
    /**
     * {@inheritdoc}
     */
    protected function YForXEqualsRFormula($D, $E, $F)
    {
        return 2*$D + ($D * $E / 100);
    }
}
