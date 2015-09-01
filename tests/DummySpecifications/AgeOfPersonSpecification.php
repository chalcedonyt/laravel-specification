<?php
namespace DummySpecifications;

class AgeOfPersonSpecification extends \Chalcedonyt\Specification\AbstractSpecification
{

    private $minAge;
    private $maxAge;
    /**
    * Set properties here for a parameterized specification.
    *
    */
    public function __construct($min_age, $max_age)
    {
        $this -> minAge = $min_age;
        $this -> maxAge = $max_age;
    }

    /**
    * Tests an object and returns a boolean value
    *
    * @var Array $object
    */

    public function isSatisfiedBy($object)
    {
        return $this -> minAge <= $object['age'] && $this -> maxAge >= $object['age'];
    }

}
