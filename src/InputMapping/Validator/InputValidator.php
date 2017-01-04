<?php

namespace InputMapping\Validator;

/**
 * Responsible for validating input data for the mapping algorithm
 */
class InputValidator
{
    /**
     *
     * Validates incomming input according to given set of rules:
     *
     * A: bool
     * B: bool
     * C: bool
     * D: int
     * E: int
     * F: int
     *
     * @param array $input
     * @param array $requiredKeys
     *
     * @return bool
     */
    public static function validate(array $input, $requiredKeys = array('A', 'B', 'C', 'D', 'E', 'F'))
    {
        $presentKeys = array_intersect( array_keys($input), $requiredKeys);

        return count($presentKeys) === count($requiredKeys) &&
        is_bool($input['A']) &&
        is_bool($input['B']) &&
        is_bool($input['C']) &&
        is_int($input['D']) &&
        is_int($input['E']) &&
        is_int($input['F']);
    }
}
