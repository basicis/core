<?php
namespace Basicis\Cache;

use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\CacheItemInterface;
use Basicis\Cache\InvalidArgumentException;
use Basicis\Cache\CacheItem;

/**
 * CacheItemPool generates CacheItemInterface objects.
 *
 * The primary purpose of Cache\CacheItemPoolInterface is to accept a key from
 * the Calling Library and return the associated Cache\CacheItemInterface object.
 * It is also the primary point of interaction with the entire cache collection.
 * All configuration and initialization of the Pool is left up to an
 * Implementing Library.
 *
 * @category Basicis/Cache
 * @package  Basicis/Cache
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Cache/CacheItemPool.php
 */
class CacheItemPool implements CacheItemPoolInterface
{
    /**
     * $items variable
     *
     * @var array|CacheItem[]
     */
    private $items = [];

    /**
     * Function addItem
     *
     * @param string                                 $key
     * @param mixed                                  $value
     * @param \DateTimeInterface|null                $expiration
     * @param int|string|\DateIntervalInterface|null $time
     */
    public function addItem(
        string $key = null,
        $value = null,
        $expiration = null,
        $time = null
    ) : CacheItemPoolInterface {
        if ($key === null) {
            throw new InvalidArgumentException("The key string '$key' is not a legal value.");
            return $this;
        }
        $this->items[$key] = new CacheItem($key, $value, $expiration, $time);
        return $this;
    }

    /**
     * Function withItem
     *
     * @param string                                 $key
     * @param CacheItemInterface|mixed               $value
     * @param \DateTimeInterface|null                $expiration
     * @param int|string|\DateIntervalInterface|null $time
     */
    public function withItem(string $key, $value, $expiration = null, $time = null) : CacheItemPoolInterface
    {
        if ($value instanceof CacheItemInterface) {
            $this->items[$key] = $item;
            return $this;
        }
        return $this->addItem($key, $value, $expiration, $time);
    }

    /**
     * Function getItem
     * Returns a Cache Item representing the specified key.
     * This method must always return a CacheItemInterface object, even in case of
     * a cache miss. It MUST NOT return null.
     *
     * @param  string $key
     *   The key for which to return the corresponding Cache Item.
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     * @return CacheItemInterface
     *   The corresponding Cache Item.
     */
    public function getItem($key) : CacheItemInterface
    {
        if (isset($this->items[$key])) {
            return $this->items[$key];
        }
            
        if (empty($key) | !is_string($key)) {
            throw new InvalidArgumentException("The key string '$key' is not a legal value.");
            return new CacheItem();
        }
    }


    /**
     * Function getItems
     * Returns a traversable set of cache items.
     *
     * @param  string[] $keys
     *   An indexed array of keys of items to retrieve.
     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     * @return array|\Traversable
     *   A traversable collection of Cache Items keyed by the cache keys of
     *   each item. A Cache item will be returned for each key, even if that
     *   key is not found. However, if no keys are specified then an empty
     *   traversable MUST be returned instead.
     */
    public function getItems(array $keys = array())
    {
        $items = [];
        if ($keys === array()) {
            return $this->items ?? [];
        }

        foreach ($keys as $key) {
            if ($this->hasItem($key)) {
                $items[$key] = $this->getItem($key);
            }
        }
        return $items;
    }


    /**
     * Function hasItem
     * Confirms if the cache contains specified cache item.
     *
     * Note: This method MAY avoid retrieving the cached value for performance reasons.
     * This could result in a race condition with CacheItemInterface::get(). To avoid
     * such situation use CacheItemInterface::isHit() instead.
     *
     * @param  string $key
     *   The key for which to check existence.
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     * @return bool
     *   True if item exists in the cache, false otherwise.
     */
    public function hasItem($key) : bool
    {
        if (empty($key) | !is_string($key)) {
            throw new InvalidArgumentException("The key string '$key' is not a legal value or no exists.");
            return false;
        }
        return (isset($this->items[$key]) && $this->items[$key]->isHit());
    }


    /**
     * Function clear
     * Deletes all items in the pool.
     *
     * @return bool
     *   True if the pool was successfully cleared. False if there was an error.
     */
    public function clear(): bool
    {
        $this->items = [];
        return (count($this->items) == 0);
    }


    /**
     * Funtion deleteItem
     * Removes the item from the pool.
     *
     * @param  string $key
     *   The key to delete.
     * @throws InvalidArgumentException
     *   If the $key string is not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     * @return bool
     *   True if the item was successfully removed. False if there was an error.
     */
    public function deleteItem($key): bool
    {
        if (empty($key) | !is_string($key)) {
            throw new InvalidArgumentException("The key string '$key' is not a legal value.");
        }

        if (isset($this->items[$key])) {
            unset($this->items[$key]);
            return true;
        }
        return false;
    }


    /**
     * Function deleteItems
     * Removes multiple items from the pool.
     *
     * @param  string[] $keys
     *   An array of keys that should be removed from the pool.
     * @throws InvalidArgumentException
     *   If any of the keys in $keys are not a legal value a \Psr\Cache\InvalidArgumentException
     *   MUST be thrown.
     * @return bool
     *   True if the items were successfully removed. False if there was an error.
     */
    public function deleteItems(array $keys) : bool
    {
        foreach ($keys as $key) {
            if ($this->hasItem($key)) {
                $this->deleteItem($key);
                if ($this->hasItem($key)) {
                    return false;
                }
            }
        }
        return true;
    }


    /**
     * Persists a cache item immediately.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   True if the item was successfully persisted. False if there was an error.
     */
    public function save(CacheItemInterface $item) : bool
    {
        //
    }


    /**
     * Sets a cache item to be persisted later.
     *
     * @param CacheItemInterface $item
     *   The cache item to save.
     *
     * @return bool
     *   False if the item could not be queued or if a commit was attempted and failed. True otherwise.
     */
    public function saveDeferred(CacheItemInterface $item) : bool
    {
        //
    }

    /**
     * Persists any deferred cache items.
     *
     * @return bool
     *   True if all not-yet-saved items were successfully saved or there were none. False otherwise.
     */
    public function commit() : bool
    {
        //
    }
}
