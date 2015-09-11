<?php
namespace Chalcedonyt\Specification;

interface SpecificationInterface
{
    /**
     * Creates a logical AND specification
     *
     * @param SpecificationInterface $specification
     */
     public function andSpec( SpecificationInterface $specification );

     /**
      * Creates a logical OR specification
      *
      * @param SpecificationInterface $specification
      */
      public function orSpec( SpecificationInterface $specification );

      /**
       * Creates a logical NOT specification
       *
       * @param SpecificationInterface $specification
       */
       public function notSpec();
}
?>
