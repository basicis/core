<?php
namespace Basicis\Controller;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Basicis\Http\Server\RequestHandler;
use Basicis\Model\Model;
use Basicis\Model\Models;
use Basicis\Core\Annotations;
use Basicis\Exceptions\InvalidArgumentException;
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
abstract class Controller extends RequestHandler implements ControllerInterface
{
    /**
     * Function handle
     * Default method
     *
     * @param ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param callable $next
     * @param object|array|null $args
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ) : ResponseInterface {
        $app = $request->getAttribute("app");
        $args = (object) array_merge(
            $request->getAttribute("route")->getArguments(),
            $request->getParsedBody() ?? []
        );
        $action = $request->getAttribute("action");

        $request->withoutAttribute("action")
                ->withoutAttribute("route")
                ->withoutAttribute("app");

        $actionResponse = $this->$action($app, $args);
        if ($actionResponse instanceof ResponseInterface) {
            return $next($request, $actionResponse);
        }

        if (!$actionResponse instanceof ResponseInterface) {
            $type = gettype($actionResponse);
            throw new InvalidArgumentException(
                "Controller must return an instance of ResponseInterface $type given.",
                4
            );
        }
        return $next($request, $response);
    }

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
        if ($class !== null) {
            $uniqueColumns = self::extractUniqueColumns($class, (array) $args);
            if (count($uniqueColumns) >= 1 && $class::exists($uniqueColumns)) {
                return $app->json(null, 406);
            }

            $model = new $class((array) $args);
            if ($model instanceof $class) {
                $model->save();
                if ($class::exists($uniqueColumns)) {
                    return $app->json($model->__toArray())->withStatus(201);
                }
            }
            return $app->json(null, 400);
        }
        return $app->json("Annotation @Model <class> no is defined.", 500);
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
    public function update(App $app, object $args = null) : ResponseInterface
    {
        $class = $this->getModelByAnnotation();
        if ($class !== null && isset($args->id)) {
            try {
                if (!$class::exists(["id" => $args->id])) {
                    return $app->json(null, 404);
                }

                $model = $class::findOneBy(["id" => $args->id]);
                if ($model instanceof $class) {
                    foreach ((array) $args as $name => $value) {
                        $method = "set".ucfirst($name);
                        if (method_exists($model, $method)) {
                            $model->$method($value);
                        }
                    }
                    $model->save();
                    return $app->json($model->__toArray(), 202);
                }
                return $app->json(null, 400);
            } catch (\Exception $e) {
                return $app->json($e->getMessage(), 500);
            }
        }
        return $app->json("Annotation @Model or argument 'id' no is defined.", 500);
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
    public function delete(App $app, object $args = null) : ResponseInterface
    {
        $class = $this->getModelByAnnotation();
        if ($class !== null && isset($args->id)) {
            $findBy = ["id" => $args->id];
            if (!$class::exists($findBy)) {
                return $app->json(null, 404);
            }

            $model = $class::findOneBy($findBy);
            $statusCode = 400;

            if ($model !== null && $model instanceof Model) {
                try {
                    $statusCode = $model->delete() ? 200 : 400;
                } catch (\Exception $e) {
                    $statusCode = 500;
                }
            }
            return $app->json(null, $statusCode);
        }
        return $app->json("Annotation @Model or argument 'id' no is defined.", 500);
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
    public function find(App $app, object $args = null) : ResponseInterface
    {
        $class = $this->getModelByAnnotation();
        if ($class !== null && class_exists($class)) {
            $model = $class::findOneBy((array) $args);
            if ($model instanceof $class) {
                return $app->json($model->__toArray(), 200);
            }
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
    public function all(App $app, object $args = null) : ResponseInterface
    {
        $class = $this->getModelByAnnotation();
        if ($class !== null && class_exists($class)) {
            $models = $class::allToArray();
            if ($models !== null) {
                return $app->json($models, 200);
            }
        }
        return $app->getResponse()->withStatus(404);
    }

    /**
     * Function getModelByAnnotation
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
            $annotationProp = $class::getPropertyAnnotation($pro->getName(), "Column");
            if ($annotationProp !== null &&
                array_key_exists("unique", $annotationProp) &&
                $annotationProp["unique"] === "true") {
                if (isset($args[$pro->getName()])) {
                    $argsForFind[$pro->getName()] = $args[$pro->getName()];
                }
            }
        }
        return $argsForFind;
    }
}
