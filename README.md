# Some common helpers for PHP classes 


## GettersCacheTrait

Allow to cache values returned by getters during the lifetime of the object.

Example:

```php
<?php

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
