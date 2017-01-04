<?php

namespace InputMapping\Mapping;

/**
 * Datastructire holding the output of a mapping procedure
 */
class MappingResult
{
    private $X;
    private $Y;

    public function __construct($X, $Y)
    {
        $this->X = $X;
        $this->Y = $Y;
    }

    public function toArray()
    {
        return array("X" => $this->X, "Y" => $this->Y);
    }

    /**
     * @return mixed
     */
    public function getX()
    {
        return $this->X;
    }

    /**
     * @return mixed
     */
    public function getY()
    {
        return $this->Y;
    }
}
