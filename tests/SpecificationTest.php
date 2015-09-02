<?php
/**
 * Tests all exposed index and show endpoints
 */
use DummySpecifications\AgeOfPersonSpecification;
use DummySpecifications\MalePersonSpecification;
use Chalcedonyt\Specification\AndSpec;
use Chalcedonyt\Specification\NotSpec;

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
         $adult_spec = new AgeOfPersonSpecification(21, 80);
         $teenager_spec = new AgeOfPersonSpecification(13, 19);
         $puberty_spec = new AgeOfPersonSpecification(15, 19);

         $male_spec = new MalePersonSpecification;
         $female_spec = new NotSpec($male_spec);

         $young_teenage_female = ['age' => 13, 'gender' => MalePersonSpecification::GENDER_FEMALE ];
         $teenage_female = ['age' => 15, 'gender' => MalePersonSpecification::GENDER_FEMALE ];
         $adult_female = ['age' => 22, 'gender' => MalePersonSpecification::GENDER_FEMALE ];

         $nested_female_spec =  $puberty_spec -> andSpec( $teenager_spec -> andSpec( $female_spec ) );
         $this -> assertEquals( $nested_female_spec -> isSatisfiedBy( $teenage_female ), true );
         $this -> assertEquals( $nested_female_spec -> isSatisfiedBy( $young_teenage_female ), false );

         $any_young_female_spec = $female_spec -> andSpec( $teenager_spec -> orSpec( $puberty_spec ));
         $this -> assertEquals( $nested_female_spec -> isSatisfiedBy( $teenage_female ), true );
         $this -> assertEquals( $nested_female_spec -> isSatisfiedBy( $adult_female ), false );

     }

     /**
      * Testing remainder
      */
      public function testRemainderUnsatisfiedBy(){
          $any_age_spec = new AgeOfPersonSpecification(1, 80);

          $male_spec = new MalePersonSpecification;
          $female_spec = new NotSpec($male_spec);

          $male = ['age' => 16, 'gender' => MalePersonSpecification::GENDER_MALE ];

          $any_young_female_spec = new AndSpec( $female_spec, $any_age_spec );
          $this -> assertEquals( $any_young_female_spec -> isSatisfiedBy( $male ), false );

          //returns the $female_spec
          $unfulfilled_spec =  $any_young_female_spec -> remainderUnsatisfiedBy( $male );
          $inverse_female_spec = new NotSpec( $unfulfilled_spec );
          $this -> assertEquals( $inverse_female_spec -> isSatisfiedBy( $male ), true );

      }

}

?>
