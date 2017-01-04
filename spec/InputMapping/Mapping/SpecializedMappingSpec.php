<?php

namespace spec\InputMapping\Mapping;

use InputMapping\Enum\XEnum;
use InputMapping\Mapping\MappingResult;
use InputMapping\Mapping\SpecializedMapping;
use InputMapping\Model\Input;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpecializedMappingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SpecializedMapping::class);
    }

    function it_calculates_mapping_for_valid_data()
    {
        /**
         * A && B && !C => X = S
         * A && B && C => X = R
         * !A && B && C => X =T
         * [other] => [error]
         * X = S => Y = D + (D * E / 100)
         * X = R => Y = 2D + (D * E / 100))
         * X = T => Y = D - (D * F / 100)
         */

        $validData = array(
            'A' => true,
            'B' => true,
            'C' => true,
            'D' => 1,
            'E' => 2,
            'F' => 3
        );

        $input = new Input(...array_values($validData));

        $expectedResult = new MappingResult(XEnum::R, 2.02);

        $this->calculate($input)->shouldEqualTo($expectedResult);
    }

    public function getMatchers()
    {
        return [
            'equalTo' => function (MappingResult $left, MappingResult $right) {
                return $left->getX() === $right->getX() && $left->getY() === $right->getY();
            }
        ];
    }
}
