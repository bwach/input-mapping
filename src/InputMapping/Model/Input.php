<?php

namespace InputMapping\Model;


use InputMapping\Validator\InputValidator;

class Input
{
    private $A;
    private $B;
    private $C;
    private $D;
    private $E;
    private $F;

    /**
     * Input constructor.
     * @param $A
     * @param $B
     * @param $C
     * @param $D
     * @param $E
     * @param $F
     */
    public function __construct($A, $B, $C, $D, $E, $F)
    {
        $this->A = $A;
        $this->B = $B;
        $this->C = $C;
        $this->D = $D;
        $this->E = $E;
        $this->F = $F;
    }

    public static function fromArray(array $input)
    {
        if (InputValidator::validate($input, array_keys(get_class_vars(__CLASS__)))) {
            // this is not a universal solution
            ksort($input);

            return new self(...array_values($input));
        }

        return null;
    }

    public function toArray()
    {
        return get_object_vars($this);
    }

    /**
     * @return mixed
     */
    public function getA()
    {
        return $this->A;
    }

    /**
     * @return mixed
     */
    public function getB()
    {
        return $this->B;
    }

    /**
     * @return mixed
     */
    public function getC()
    {
        return $this->C;
    }

    /**
     * @return mixed
     */
    public function getD()
    {
        return $this->D;
    }

    /**
     * @return mixed
     */
    public function getE()
    {
        return $this->E;
    }

    /**
     * @return mixed
     */
    public function getF()
    {
        return $this->F;
    }
}