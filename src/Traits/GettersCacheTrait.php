<?php
/**
 * Class helpers
 */
namespace Mekras\ClassHelpers\Traits;

use Closure;

/**
 * Cache for getters
 *
 * Allow to cache values returned by getters during the lifetime of the object.
 *
 * Example:
 *
 * ```php
 * class MyClass
 * {
 *     use GettersCacheTrait;
 *
 *     public function getFoo()
 *     {
 *         return $this->getCachedProperty(
 *             'foo',
 *             function () { return new FooClass($this->foo); }
 *         );
 *     }
 * ```
 *
 * Method `getCachedProperty` checks if key `foo` exists in the object's internal cache, and if it
 * exists, returns cached value. Otherwise factory function will be called to get value.
 *
 * @since 1.00
 */
trait GettersCacheTrait
{
    /**
     * Internal getters cache
     *
     * @var array
     */
    private $gettersCache = [];

    /**
     * Return cached value for $name or call $factory to get new value
     *
     * @param string  $name    cache entry key
     * @param Closure $factory value factory function
     *
     * @return mixed
     *
     * @since 1.00
     */
    protected function getCachedProperty($name, Closure $factory)
    {
        $name = (string) $name;
        if (!array_key_exists($name, $this->gettersCache)) {
            $this->gettersCache[$name] = call_user_func($factory);
        }
        return $this->gettersCache[$name];
    }

    /**
     * Change cached value
     *
     * Useful for setters.
     *
     * @param string $name  cache entry key
     * @param mixed  $value new value
     *
     * @since 1.00
     */
    protected function setCachedProperty($name, $value)
    {
        $this->gettersCache[$name] = $value;
    }
}
