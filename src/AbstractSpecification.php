<?php
namespace Chalcedonyt\Specification;

/**
 * An abstract specification allows the creation of wrapped specifications
 */
abstract class AbstractSpecification implements SpecificationInterface
{
    /**
     * Checks if given item meets all criteria
     *
     * @param Item $item
     *
     * @return bool
     */
    abstract public function isSatisfiedBy($item);

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
