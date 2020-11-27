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
     * @var string $path
     */
    private $path;

    public function __construct(string $path = null)
    {
        if ($path !== null) {
            $this->path = $path;
            $this->view = new \Twig\Environment(new \Twig\Loader\FilesystemLoader($path));
        }
    }


    private function extractTemplate(string $name, string &$path, &$data = []) : string
    {
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

        /*if (!file_exists($path.$template)) {
           $data = [
               'title' =>'Template Not Found!',
                'subtitle' => "Template File <b>$template</b> no exists in <u>$path</u> !"
            ];
            $template = 'layout/msg.html';
        }*/

        return  $template;
    }


    public function setFilters(array $filters)
    {
        foreach ($filters as $key => $filter) {
            if ($filter instanceof \Twig\TwigFunction) {
                $this->view->addFunction($filter);
            }
        }
    }


    public function getView(string $name, $data = []) : string
    {
        $template = $this->extractTemplate($name, $this->path, $data);
        if (file_exists($this->path . $template)) {
            return $this->view->render($template, $data);
        }

        return "";
    }
}
