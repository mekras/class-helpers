# Some common helpers for PHP classes 


## GettersCacheTrait

Allow to cache values returned by getters during the lifetime of the object.

Example:

```php
<?php
use Mekras\ClassHelpers\Traits\GettersCacheTrait;

class MyClass
{
    use GettersCacheTrait;

    private $foo;

    public function getFoo()
    {
        return $this->getCachedProperty(
            'foo',
            function () { return new FooClass($this->foo); }
        );
    }

    public function setFoo($value)
    {
        if ($value instanceof FooClass) {
            $this->setCachedProperty('foo', $value);
            $value = $value->getId();
        }
        $this->foo = $value;
    }
}
```

## LoggingHelperTrait

* Logger setter/getter.
* getLogger return NullLogger when no logger set — you can omit logger checks.
* Shortcut method to log exceptions.

Example:

```php
<?php
use Mekras\ClassHelpers\Traits\LoggingHelperTrait;

class MyClass
{
    use LoggingHelperTrait;

    public function foo()
    {
        ...
        $this->getLogger()->notice('...');
    }

    public function bar($value)
    {
        try {
            ...
        } catch (\Exception $e) {
            $this->logException($e, 'Executing bar');
        }
    }
}
```

## WrapperTrait

Helper for creating wrapper classes

Example:

```php
<?php
use Foo\FooInterface;
use Mekras\ClassHelpers\Traits\WrapperTrait;

class MyClass implements FooInterface
{
    use WrapperTrait;

    public function __construct(FooInterface $wrappedObject)
    {
        $this->setWrappedObject($wrappedObject);
    }

    public function foobar()
    {
        // Overridden logic here
    }
}

$foo = get_foo_instance(); // Somehow get instance of class implementing FooInterface
$wrap = new MyClass($foo);

// Now $wrap can be used instead of $foo, but with overridden foobar method.
```
