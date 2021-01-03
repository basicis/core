<?php
namespace Test\Model;

use PHPUnit\Framework\TestCase;
use Basicis\Model\Model;
use Basicis\Model\Models;
use Basicis\Model\ExampleModel;

/**
 * Class BasicisTest
 */

class ModelTest extends TestCase
{
    /**
     * $model variable
     *
     * @var Model
     */
    private $model;

    /**
     * Function __construct
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->model = new ExampleModel();
    }

    /**
     * Function testConstruct
     * @return void
     */
    public function testConstruct()
    {
        $this->assertInstanceOf(ExampleModel::class, $this->model);
    }

    /**
     * Function testSetCreated
     * @return void
     */
    public function testSetCreated()
    {
        $this->assertInstanceOf(ExampleModel::class, $this->model->setCreated("2020-06-10 09:00"));
    }

    /**
     * Function testGetCreated
     * @return void
     */
    public function testGetCreated()
    {
        $this->assertInstanceOf(\DateTime::class, $this->model->getCreated());
    }

    /**
     * Function testSetUpdated
     * @return void
     */
    public function testSetUpdated()
    {
        $this->assertInstanceOf(ExampleModel::class, $this->model->setUpdated("2020-06-10 10:00"));
        $this->model->save();
    }


    /**
     * Function testGetUpdated
     * @return void
     */
    public function testGetUpdated()
    {
        $this->assertInstanceOf(\DateTime::class, $this->model->getUpdated());
    }

    
    /**
     * Function testArrayAndJson
     * @return void
     */
    public function testArrayAndJson()
    {
        $this->assertEquals(true, is_array($this->model->__toArray()));
        $this->assertEquals(true, is_string($this->model->__toString()));
    }


    /**
     * Function testArrayAndJson
     * @return void
     */
    public function testModels()
    {
        $models = new Models(get_class($this->model));
        $this->assertEquals(true, is_array($models->getAll()));

        $models = new Models(get_class($this->model), ["id" => 1]);
        $this->assertEquals(true, is_array($models->getArray()));
    }
}
