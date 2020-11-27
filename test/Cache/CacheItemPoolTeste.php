<?php 
namespace Test\Cache;
use PHPUnit\Framework\TestCase;
use Psr\Cache\CacheItemInterface;
use Basicis\Cache\CacheItem;
use Basicis\Cache\CacheItemPool;


/**
 * Class Test\Cache\CacheItemPoolTest;
 */

 class CacheItemPoolTest extends TestCase
 {
    private $pool;

    public function __construct()
    {
        parent::__construct();
        $this->pool = new CacheItemPool();
    }

    public function testGetItem()
    {
        $this->assertInstanceOf(CacheItemInterface::class, $this->pool->getItem('test'));
    }

    public function testGetItems()
    {
        $this->assertEquals(true, is_array($this->pool->getItems(['test'])));
    }

    public function testHasItem()
    {   
        $this->assertEquals(false, $this->pool->hasItem('test'));
    }

    public function testClear()
    {
        $this->assertEquals(true, $this->pool->clear());
    }

    public function testDeleteItem()
    {
        $this->assertEquals(false, $this->pool->deleteItem('test'));
        $this->pool->withItem('test', 'Test Value!');
        $this->assertEquals(true, $this->pool->deleteItem('test'));
    }

    public function testDeleteItems()
    {
        $this->assertEquals(false, $this->pool->deleteItems(['test', 'test2']));
        $this->pool->withItem('test', 'Test Value!')->withItem('test2', 'Test2 Value!');
        //$this->assertEquals(true, $this->pool->deleteItem('test'));
    }


}    