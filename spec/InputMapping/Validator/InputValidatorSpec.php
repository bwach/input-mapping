<?php

namespace spec\InputMapping\Validator;

use InputMapping\Validator\InputValidator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InputValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(InputValidator::class);
    }

    function it_validates_proper_input()
    {
        $validData = array(
            'A' => true,
            'B' => true,
            'C' => true,
            'D' => 1,
            'E' => 2,
            'F' => 3
        );

        $this->validate($validData)->shouldReturn(true);
    }

    function it_validates_missing_key_as_false()
    {
        $dataWithMissingKey = array(
            'B' => true,
            'C' => true,
            'D' => 1,
            'E' => 2,
            'F' => 3
        );

        $this->validate($dataWithMissingKey)->shouldReturn(false);
    }

    function it_validates_wrong_data_type_as_false()
    {
        $boolOnlyData = array(
            'A' => true,
            'B' => true,
            'C' => true,
            'D' => true,
            'E' => true,
            'F' => true
        );

        $this->validate($boolOnlyData)->shouldReturn(false);

        $intOnlyData = array(
            'A' => 1,
            'B' => 2,
            'C' => 3,
            'D' => 1,
            'E' => 2,
            'F' => 3
        );

        $this->validate($intOnlyData)->shouldReturn(false);

        $stringData = array(
            'A' => 'A',
            'B' => 'B',
            'C' => 'C',
            'D' => 'D',
            'E' => 'E',
            'F' => 'F'
        );

        $this->validate($stringData)->shouldReturn(false);
    }
}
