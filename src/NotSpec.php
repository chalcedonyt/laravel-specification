<?php
namespace Chalcedonyt\Specification;

/**
 * A logical Not specification
 */
class NotSpec extends AbstractSpecification
{

    protected $spec;

    /**
     * Creates a new specification wrapping another
     *
     * @param SpecificationInterface $spec
     */
    public function __construct(SpecificationInterface $spec)
    {
        $this->spec = $spec;
    }

    /**
     * Returns the negated result of the wrapped specification
     *
     * @param Item $item
     *
     * @return bool
     */
    public function isSatisfiedBy($item)
    {
        return !$this->spec->isSatisfiedBy($item);
    }
}
