<?php
namespace Chalcedonyt\Specification;

abstract class CompositeSpecification extends AbstractSpecification
{
    /**
     * @var Array An array of SpecificationInterface instances.
     */
    public $specifications;

    /**
     * Returns unsatisfied specifications as a CompositeSpecification
     * @param mixed $candidate
     * @return CompositeSpecification
     */
    public function remainderUnsatisfiedBy( $candidate )
    {
        if( $this -> isSatisfiedBy( $candidate ))
            return null;
        else return $this -> remainderUnsatisfiedAsCompositeSpecification( $candidate );
    }

    /**
     * Constructs a CompositeSpecification out of the specifications that have not been satisfied
     *
     * @param mixed $candidate
     * @return CompositeSpecification
     */
    private function remainderUnsatisfiedAsCompositeSpecification( $candidate )
    {
        $composite_spec = new static;
        $composite_spec -> specifications = $this -> remaindersUnsatisfiedBy( $candidate );
        return $composite_spec;
    }

    /**
     * Evaluates every specification and return the ones that fail
     *
     * @param mixed $candidate
     * @return Array Array of SpecificationInterface
     */
    private function remaindersUnsatisfiedBy( $candidate )
    {
        $unsatisfied = [];
        foreach( $this -> specifications as $specification ){
            if( !$specification -> isSatisfiedBy($candidate))
                $unsatisfied[]= $specification;
        }
        return $unsatisfied;
    }

}

?>
