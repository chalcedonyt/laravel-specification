# laravel-specification


An adaptation of the Specification Pattern as done by https://github.com/domnikl/DesignPatternsPHP, adding an artisan command to quickly create specifications.

## Install

Via Composer (please change your `minimum-stability` to "dev")

``` bash
$ composer require chalcedonyt/laravel-specification
```
Then run `composer update`. Once composer is finished, add the service provider to the `providers` array in `app/config/app.php`:
```
Chalcedonyt\Specification\Providers\SpecificationServiceProvider::class
```

## Generating Specifications

An artisan command will be added to quickly create specifications.
``` php
php artisan make:specification [NameOfSpecification]
```
Adding a `--parameters` flag will prompts for parameters to be inserted into the constructor when generated:
```
Enter the class or variable name for parameter 0 (Examples: \App\User or $value) [Blank to stop entering parameters] [(no_param)]:
 > \App\User

 Enter the class or variable name for parameter 1 (Examples: \App\User or $value) [Blank to stop entering parameters] [(no_param)]:
 > $my_value
 ```
 Results in

 ```php
 class NewSpecification extends AbstractSpecification
 {

     /**
     * @var  \App\User
     */
     protected $user;

     /**
     * @var  
     */
     protected $myValue;


     /**
     *
     *  @param  \App\User $user
     *  @param   $myValue
     *
     */
     public function __construct(\App\User $user, $my_value)
     {
         $this -> user = $user;
         $this -> myValue = $my_value;
     }

     /**
     * Tests an object and returns a boolean value
     *
     * @var  mixed
     */

     public function isSatisfiedBy($candidate)
     {
         //return a boolean value
     }

 }
 ```

## Usage
``` php
class AgeOfPersonSpecification extends \Chalcedonyt\Specification\AbstractSpecification
{

    protected $minAge;
    protected $maxAge;

    /**
    * Set properties here for a parameterized specification.
    *
    */
    public function __construct($min_age, $max_age)
    {
        $this -> minAge = $min_age;
        $this -> maxAge = $max_age;
    }

    /**
    * Tests an object and returns a boolean value
    *
    * @var Array $candidate
    */

    public function isSatisfiedBy($candidate)
    {
        return $this -> minAge <= $candidate['age'] && $this -> maxAge >= $candidate['age'];
    }

}
```



```php
class MalePersonSpecification  extends \Chalcedonyt\Specification\AbstractSpecification
{
    const GENDER_MALE = 1;
    const GENDER_FEMALE = 2;

    /**
    * Tests an object and returns a boolean value
    *
    * @var Array candidate
    */

    public function isSatisfiedBy($candidate)
    {
        return $candidate['gender'] == self::GENDER_MALE;
    }
}
```

```php
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
```

You may also retrieve unfulfilled specifications via the `remainderUnsatisfiedBy` property

```php
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
```
## Change log

* 0.4.4 You can now create a Specification inside a directory by specifying it in the classname, e.g. `php artisan make:specification MyDir\\MySpec`
* 0.4.2 Removed the `isSatisfiedBy` method from the abstract and interface. This allows type hinting on the $candidate.
* 0.4.1 Tweaked the generated views to use camel_case on any parameters.
* 0.4 Updated console command. You may now specify constructor parameters for the specification generator  by entering the `--parameters` flag
* 0.3 Removed functionality to type-hint the argument to isSatisfiedBy, as PHP doesn't allow overloading abstract methods.
* 0.2 Added `remainderUnsatisfiedBy` functions

## Testing

## Credits

- Dominic Liebler [https://github.com/domnikl/DesignPatternsPHP]
- C# Specification Framework by Firzen [https://specification.codeplex.com/]
- The original Specification Pattern document by Eric Evans and Martin Fowler [http://www.martinfowler.com/apsupp/spec.pdf]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
