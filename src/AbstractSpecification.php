<?php
namespace Chalcedonyt\Specification;

/**
 * An abstract specification allows the creation of wrapped specifications
 */
abstract class AbstractSpecification implements SpecificationInterface
{
    /**
     * Returns the specifications the candidate does not fulfil
     *
     * @param mixed $candidate
     *
     * @return SpecificationInterface or null
     */

    function remainderUnsatisfiedBy( $candidate ){
        if( !$this -> isSatisfiedBy( $candidate ))
            return $this;
        return null;
    }

    /**
     * Creates a new logical AND specification
     *
     * @param SpecificationInterface $spec
     *
     * @return SpecificationInterface
     */
    public function andSpec(SpecificationInterface $spec)
    {
        return new AndSpec($this, $spec);
    }

    /**
     * Creates a new logical OR composite specification
     *
     * @param SpecificationInterface $spec
     *
     * @return SpecificationInterface
     */
    public function orSpec(SpecificationInterface $spec)
    {
        return new OrSpec($this, $spec);
    }

    /**
     * Creates a new logical NOT specification
     *
     * @return SpecificationInterface
     */
    public function notSpec()
    {
        return new NotSpec($this);
    }
}
