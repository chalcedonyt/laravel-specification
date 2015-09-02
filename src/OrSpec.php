<?php
namespace Chalcedonyt\Specification;

/**
 * A logical OR specification
 */
class OrSpec extends CompositeSpecification
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
     * A composite wrapper of two specifications
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
     * Returns the evaluation of all wrapped specifications as a logical OR
     *
     * @param mixed $candidate
     *
     * @return bool
     */
    public function isSatisfiedBy($candidate)
    {
        foreach( $this -> specifications as $specification )
        {
            if( $specification -> isSatisfiedBy( $candidate ))
                return true;
        }
        return false;
    }
}
?>
