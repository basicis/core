<?php
namespace Basicis\Controller;

use Psr\Http\Message\ResponseInterface;
use Basicis\Controller\ControllerInterface;
use Basicis\Model\Model;
use Basicis\Model\Models;
use Basicis\Core\Annotations;
use Basicis\Basicis as App;

/**
 * Controller Class - Controller implements ControllerInterface,
 * all controller classes extend from this
 * @category Basicis/Controller
 * @package  Basicis/Controller
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Controller/Controller.php
 */
abstract class Controller implements ControllerInterface
{
    /**
     * Function index
     * Default method
     * @param \Basicis\Basicis $app
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index(App $app, object $args = null) : ResponseInterface
    {
        $app->handleError("Test index");
        return $app->getResponse();
    }

    /**
     * Function create
     * Creates a model of the specified class
     * @param \Basicis\Basicis $app
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function create(App $app, object $args = null) : ResponseInterface
    {
        $class = $this->getModelByAnnotation();
        if ($class !== null && get_parent_class($class) === "Basicis\Model\Model") {
            $uniqueColumns = self::extractUniqueColumns($class, (array) $args);
            if ($class::exists($uniqueColumns)) {
                return $app->json(null, 406);
            }

            $classObj = new  $class((array) $args);
            if ($classObj instanceof $class) {
                try {
                    $classObj->save();
                    if ($class::exists($uniqueColumns)) {
                        return $app->json($classObj->__toArray(), 201);
                    }
                } catch (\Exception $e) {
                    return $app->json(null, 500);
                }
            }
            return $app->json(null, 400);
        }
        return $app->json(null, 500);
    }


    /**
     * Function update
     * Update a model of the specified class
     * @param \Basicis\Basicis $app
     * @param Model $model
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update(App $app, Model $model = null, object $args = null) : ResponseInterface
    {
        try {
            if ($model instanceof Model) {
                $class = get_class($model);
                foreach ((array) $args as $name => $value) {
                    $method = "set".ucfirst($name);
                    if (method_exists($model, $method)) {
                        $model->$method($value);
                    }
                }
                $model->save();
                return $app->json($model->__toArray(), 202);
            }
            return $app->json(null, 404);
        } catch (\Exception $e) {
            return $app->json(null, 406);
        }
    }


    /**
     * Function delete
     * Delete a model of the specified class
     * @param \Basicis\Basicis $app
     * @param Model $model
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete(App $app, Model $model = null, object $args = null) : ResponseInterface
    {
        $statusCode = 404;
        if ($model !== null && $model instanceof Model) {
            try {
                $statusCode = $model->delete() ? 200 : 400;
            } catch (\Exception $e) {
                $statusCode = 500;
            }
        }
        return $app->json(null, $statusCode);
    }


    /**
     * Function find
     * Find one a model item of the specified class
     * @param \Basicis\Basicis $app
     * @param Model $model
     * @param object $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function find(App $app, Model $model = null, object $args = null) : ResponseInterface
    {
        if ($model instanceof Model) {
            return $app->json($model->__toArray(), 200);
        }
        return $app->json()->withStatus(404);
    }


    /**
     * Function all
     * Find all a model items of the specified class
     * @param \Basicis\Basicis $app
     * @param Models $models
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function all(App $app, Models $models = null) : ResponseInterface
    {
        if ($models !== null) {
            return $app->json($models->getArray(), 200);
        }
        return $app->getResponse()->withStatus(404);
    }

    /**
     * Undocumented function
     * Get annotations model class
     * @return string|null
     */
    public function getModelByAnnotation() : ?string
    {
        $annotations = new Annotations(get_called_class());
        $model = $annotations->getClassCommentByTag("@Model");

        if ($model !== null) {
            $model = trim(str_replace("@Model", "", $model));
        }

        if (class_exists($model)) {
            return $model;
        }
        return null;
    }

    /**
     * Function extractUniqueColumns
     * Extract Unique Columns of model class and return these as array
     * @param string $class
     * @param array $args
     * @return array
     */
    public static function extractUniqueColumns(string $class, array $args) : array
    {
        $argsForFind = [];
        $props = (new Annotations($class))->getClass()->getProperties();
        foreach ($props as $key => $pro) {
            $propAnn = $class::getPropertyAnnotation($pro->getName(), "Column");
            if ($propAnn !== null && array_key_exists("unique", $propAnn) && $propAnn["unique"] === "true") {
                if (isset($args[$pro->getName()])) {
                    $argsForFind[$pro->getName()] = $args[$pro->getName()];
                }
            }
        }
        return $argsForFind;
    }
}
