<?php

namespace spec\InputMapping\Mapping;

use InputMapping\Enum\XEnum;
use InputMapping\Exception\ImproperInputException;
use InputMapping\Mapping\BaseMapping;
use InputMapping\Mapping\MappingResult;
use InputMapping\Model\Input;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class BaseMappingSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(BaseMapping::class);
    }
    
    function it_calculates_mapping_for_valid_data()
    {
        /**
         * A && B && !C => X = S
         * A && B && C => X = R
         * !A && B && C => X =T
         * [other] => [error]
         * X = S => Y = D + (D * E / 100)
         * X = R => Y = D + (D * (E - F) / 100)
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
        
        $expectedResult = new MappingResult(XEnum::R, 0.99);
        
        $this->calculate($input)->shouldEqualTo($expectedResult);

        $validData = array(
            'A' => false,
            'B' => true,
            'C' => true,
            'D' => 1,
            'E' => 2,
            'F' => 3
        );

        $input = new Input(...array_values($validData));

        $expectedResult = new MappingResult(XEnum::T, 0.97);

        $this->calculate($input)->shouldEqualTo($expectedResult);

        $validData = array(
            'A' => true,
            'B' => true,
            'C' => false,
            'D' => 1,
            'E' => 2,
            'F' => 3
        );

        $input = new Input(...array_values($validData));

        $expectedResult = new MappingResult(XEnum::S, 1.02);

        $this->calculate($input)->shouldEqualTo($expectedResult);
    }

    public function it_throws_exception_on_invalid_data()
    {
        $invalidData = array(
            'A' => false,
            'B' => false,
            'C' => false,
            'D' => 1,
            'E' => 2,
            'F' => 3
        );

        $input = new Input(...array_values($invalidData));

        $this->shouldThrow(ImproperInputException::class)->during("calculate", array($input));
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
