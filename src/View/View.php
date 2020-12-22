<?php
namespace Basicis\View;

use Basicis\Basicis as App;

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
    private $paths;

    /**
     * Function __construct
     *
     * @param array $paths
     */
    public function __construct(array $paths = [])
    {
        if ($paths !== []) {
            $this->paths = $paths;
            $this->view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader($paths));
        }
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
        if (strpos($name, '.') |   strpos($name, ':') | strpos($name, ',')) {
            $delimiter=null;
            if (strpos($name, '.')) {
                $delimiter = ".";
            } elseif (strpos($name, ':')) {
                $delimiter = ":";
            } elseif (strpos($name, ',')) {
                $delimiter = ",";
            } elseif (strpos($name, '|')) {
                $delimiter = "|";
            } elseif (strpos($name, ';')) {
                $delimiter = ";";
            }

            $explode = explode($delimiter, strtolower($name));
            $template = $explode[0];
            $content = glob($path.$explode[0].'.*');
            
            if (count($content) >= 1) {
                $template = str_replace($path, '', $content[0]);
            }
            unset($content);

            $content = glob($path . $explode[1] .'.*');
            if (count($content) >= 1) {
                $data['content'] = str_replace($path, '', $content[0]);
            }

            if (count($explode) > 2) {
                $i = 2;
                while ($i <= count($explode)) {
                    $content = glob($path . $explode[$i] .'.*');
                    if (count($content) >= 1) {
                        $data['content'.$i] = str_replace($path, '', $content[0]);
                    }
                    $i++;
                }
            }
        } else {
            $content = glob($path . $name .'.*');
            if (count($content) >= 1) {
                $template = strtolower(str_replace($path, '', $content[0]));
            }
        }

        return  $template;
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
     * @return void
     */
    public function setFilters(array $filters)
    {
        foreach ($filters as $key => $filter) {
            if ($filter instanceof \Twig\TwigFunction) {
                $this->view->addFunction($filter);
            }
        }
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
}
