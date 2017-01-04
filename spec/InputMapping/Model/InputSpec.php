<?php

namespace spec\InputMapping\Model;

use InputMapping\Model\Input;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InputSpec extends ObjectBehavior
{
    private $validData = array(
        'A' => true,
        'B' => true,
        'C' => true,
        'D' => 1,
        'E' => 2,
        'F' => 3
    );

    function let()
    {
        $this->beConstructedWith(...array_values($this->validData));
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Input::class);
    }

    function it_can_be_transformed_to_array()
    {
        $this->toArray()->shouldReturn($this->validData);
    }
}
