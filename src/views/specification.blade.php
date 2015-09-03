<?= '<?php' ?>


namespace {{ $namespace }};

use Chalcedonyt\Specification\AbstractSpecification;

class {{ $classname }} extends AbstractSpecification
{

    /**
    * Set properties here for a parameterized specification.
    *
    */
    public function __construct()
    {

    }

    /**
    * Tests an object and returns a boolean value
    *
    * @var mixed
    */

    public function isSatisfiedBy({{$object_variable}})
    {
        //return a boolean value
    }

}
