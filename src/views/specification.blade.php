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
    * @var {{$object_class == Chalcedonyt\Specification\Commands\SpecificationGeneratorCommand::NO_CLASS_SPECIFIED ? 'mixed' : $object_class}}
    */

    public function isSatisfiedBy({{$object_class == Chalcedonyt\Specification\Commands\SpecificationGeneratorCommand::NO_CLASS_SPECIFIED  ? '' : $object_class}} {{$object_variable}})
    {
        //return a boolean value
    }

}
