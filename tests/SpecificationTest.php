<?php
/**
 * Tests all exposed index and show endpoints
 */
use DummySpecifications\AgeOfPersonSpecification;
use DummySpecifications\MalePersonSpecification;

class SpecificationTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * Simple tests for a) a single spec, b) andSpec, c) orSpec d) notSpec
     */
    public function testSpecs()
    {
        $age_spec = new AgeOfPersonSpecification(10, 20);
        $male_spec = new MalePersonSpecification;

        $age_and_male_spec = $age_spec -> andSpec( $male_spec );
        $age_or_male_spec = $age_spec -> orSpec( $male_spec );
        $age_not_male_spec = $male_spec -> notSpec();

        $person = ['age' => 20, 'gender' => MalePersonSpecification::GENDER_MALE];
        $person2 = ['age' => 20, 'gender' => MalePersonSpecification::GENDER_FEMALE];

        $this -> assertEquals( $age_and_male_spec -> isSatisfiedBy( $person ), true );
        $this -> assertEquals( $age_and_male_spec -> isSatisfiedBy( $person2 ), false );
        $this -> assertEquals( $age_or_male_spec -> isSatisfiedBy( $person2 ), true );
        $this -> assertEquals( $age_not_male_spec -> isSatisfiedBy( $person2 ), true );

    }
    /**
     * Testing nested specs
     */
     public function testNestedSpecs()
     {
         $age_spec = new AgeOfPersonSpecification(10, 20);
         $narrower_age_spec = new AgeOfPersonSpecification(15, 18);
         $narrowest_age_spec = new AgeOfPersonSpecification(16, 17);
         $male_spec = new MalePersonSpecification;

         $age_and_male_spec = $age_spec -> andSpec( $narrower_age_spec -> andSpec( $narrowest_age_spec ) ) -> andSpec( $male_spec );

         $person = ['age' => 17, 'gender' => MalePersonSpecification::GENDER_MALE];
         $person2 = ['age' => 15, 'gender' => MalePersonSpecification::GENDER_MALE];

         $this -> assertEquals( $age_and_male_spec -> isSatisfiedBy( $person ), true );
         $this -> assertEquals( $age_and_male_spec -> isSatisfiedBy( $person2 ), false );

     }


}

?>
