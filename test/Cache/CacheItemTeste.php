<?php 
namespace Test\Cache;
use PHPUnit\Framework\TestCase;
use Basicis\Cache\CacheItem;


/**
 * Class Test\Cache\CacheItemTest;
 */

 class CacheItemTest extends TestCase
 {
    private $cacheItem;

    public function __construct()
    {
        parent::__construct();
        $this->cacheItem = new CacheItem('test');
    }

    public function testGetKey()
    {
        $this->assertEquals('test', $this->cacheItem->getKey());
    }

    public function testGet()
    {
        $this->assertEquals(null, $this->cacheItem->get());
    }

    public function testIsHit()
    {
        $this->assertEquals(false, $this->cacheItem->isHit());   
    }

    public function testSet()
    {
        $this->assertEquals('Test cache set!', $this->cacheItem->set('Test cache set!')->get());
        $this->assertEquals(true, $this->cacheItem->isHit());   
    }

    public function testExpiresAt()
    {
        $this->assertInstanceOf(CacheItem::class, $this->cacheItem->expiresAt(null));   
    }

    public function testExpiresAfter()
    {
        $this->assertInstanceOf(CacheItem::class, $this->cacheItem->expiresAfter(null));   
    }

 }