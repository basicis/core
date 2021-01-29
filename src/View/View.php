<?php
namespace Basicis\View;

use Basicis\Basicis as App;
use Basicis\Exceptions\InvalidArgumentException;

/**
 *  View Class
 */
class View
{
    /**
     * @var string $view
     */
    private $view;
   
    /**
     * @var array $paths
     */
    private $paths = [];

    /**
     * Function __construct
     *
     * @param array $paths
     */
    public function __construct(array $paths = null)
    {
        $this->paths = [App::path()."storage/templates/"];

        if ($paths !== null) {
            $this->paths = array_merge($this->paths, $paths);
            foreach ($this->paths as $key => $path) {
                if (!is_dir($path)) {
                    (new InvalidArgumentException("Path $path no is a directory!", 4))->log();
                    unset($this->paths[$key]);
                }
            }
        }

        $this->view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader($this->paths));
    }

    /**
     * Function extractTemplate
     * Extract template part name
     * @param string $name
     * @param string $path
     * @param array $data
     * @return string
     */
    private function extractTemplate(string $name, string &$path, &$data = []) : string
    {
        $template = "";
        $delimiter = $this->getDelimiter($name);
        if ($delimiter === null) {
            $content = glob($path . $name .'.*');
            if (count($content) >= 1) {
                $template = strtolower(str_replace($path, '', $content[0]));
            }
            return $template;
        }

        $explode = explode($delimiter, strtolower($name));
        $template = $explode[0];
        $content = glob($path.$explode[0].'.*');
       
        if (count($content) >= 1) {
            $template = str_replace($path, '', $content[0]);
        }
        unset($content);

        $included = trim($explode[1]);
        $content = glob($path . $included .'.*');
        if (count($content) >= 1) {
            $data[$included] = str_replace($path, '', $content[0]);
        }

        if (count($explode) > 2) {
            $i = 2;
            while ($i <= count($explode)) {
                $content = glob($path . $explode[$i] .'.*');
                if (count($content) >= 1) {
                    $data[$explode[$i]] = str_replace($path, '', $content[0]);
                }
                $i++;
            }
        }
        return $template;
    }

    /**
     * Function getDelimiter
     * Get delimiter template name
     * @param string $name
     * @return string|null
     */
    private function getDelimiter(string $name) : ?string
    {
        $delimiter = null;
        if (strpos($name, '|') |   strpos($name, ':') | strpos($name, ',')) {
            if (strpos($name, ':')) {
                $delimiter = ":";
            }
            
            if (strpos($name, ',')) {
                $delimiter = ",";
            }
            
            if (strpos($name, '|')) {
                $delimiter = "|";
            }
        }
        return  $delimiter;
    }

    /**
     * Function setFilters
     * Setting filters functions for use into template
     * - Setting into config/app-config.php file
     * ```php
     *  $app->setViewFilters([
     *  //here, key is required
     *  "isTrue" => function ($value = true) {
     *      return $value;
     *  }
     *  ]);
     * ```
     * - Using into Twig Template file
     * `{{isTrue($var = true)}}`
     *
     * @param array $filters
     *
     * @return View
     */
    public function setFilters(array $filters) : View
    {
        foreach ($filters as $key => $filter) {
            if (!$filter instanceof \Twig\TwigFunction) {
                throw new InvalidArgumentException("Filter function not is a instance of \Twig\TwigFunction.", 4);
                return [];
            }

            $this->view->addFunction($filter);
        }
        return $this;
    }


    /**
     * Fuction getView
     * Get a string result os template with optional $data array
     * @param string $name
     * @param array $data
     * @return string|null
     */
    public function getView(string $name, $data = []) : ?string
    {
        foreach ($this->paths as $path) {
            $template = $this->extractTemplate($name, $path, $data);
            if (file_exists($path . $template) && !is_dir($path . $template)) {
                return $this->view->render($template, $data);
            }
        }

        foreach ($this->paths as $path) {
            $errorTemplate = $path . "error.html";
            if (file_exists($errorTemplate) && !is_dir($errorTemplate)) {
                return $this->view->render("error.html", ["errorMessage" => "Template file '$name' not found!"]);
            }
        }

        return null;
    }

    /**
     * Function getFunctions
     * Get all defineds Twig functions
     * @return array
     */
    public function getFunctions() : array
    {
        return $this->view->getFunctions();
    }

    /**
     * Function hasFunction
     * Check if has a Twig function named by $name argument
     * @param string $name
     *
     * @return bool
     */
    public function hasFunction(string $name) : bool
    {
        return in_array($name, array_keys($this->getFunctions()));
    }
}
