<?php
namespace Chalcedonyt\Specification;

/**
 * A logical AND specification
 */
class AndSpec extends CompositeSpecification
{
    /**
     * @var SpecificationInterface $left
     */
    protected $left;

    /**
     * @var SpecificationInterface $right
     */
    protected $right;

    /**
     * Creation of a logical AND of unlimited specifications
     *
     * @param SpecificationInterface $left
     * @param SpecificationInterface $right
     */
    public function __construct(SpecificationInterface $left = null, SpecificationInterface $right = null)
    {
        if( $left )
        {
            $this -> left = $left;
            $this -> specifications[]= $left;
        }
        if( $right )
        {
            $this -> right = $right;
            $this -> specifications[]= $right;
        }
    }

    /**
     * Checks if the composite AND of specifications passes
     *
     * @param mixed $candidate
     *
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        foreach( $this -> specifications as $specification )
        {
            if( !$specification -> isSatisfiedBy( $candidate ))
                return false;
        }
        return true;
    }
}
