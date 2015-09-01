<?php
namespace DummySpecifications;

class MalePersonSpecification  extends \Chalcedonyt\Specification\AbstractSpecification
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;
    /**
    * Tests an object and returns a boolean value
    *
    * @var\App\User $object
    */

    public function isSatisfiedBy($person)
    {
        return $person['gender'] == self::GENDER_MALE;
    }

}
