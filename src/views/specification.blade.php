<?= '<?php' ?>


namespace {{ $namespace }};

use Chalcedonyt\Specification\AbstractSpecification;

class {{ $classname }} extends AbstractSpecification
{

@if (count($parameters))
@foreach( $parameters as $param)
    /**
    * @var {{$param['class']}}
    */
    protected ${{camel_case($param['name'])}};

@endforeach
@endif

    /**
    *
@if (!count($parameters))
    * Set properties here for a parameterized specification.
@else
@foreach( $parameters as $param)
    *  @param {{$param['class']}} ${{camel_case($param['name'])}}
@endforeach
@endif
    */
    public function __construct({{$parameter_string}})
    {
@if (count($parameters))
@foreach( $parameters as $param)
        $this -> {{camel_case($param['name'])}} = ${{$param['name']}};
@endforeach
@endif
    }

    /**
    * Tests an object and returns a boolean value
    * @param mixed
    * @return Boolean
    */

    public function isSatisfiedBy({{$object_variable}})
    {
        //return a boolean value
    }

}
