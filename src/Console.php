<?php
namespace Basicis;

use Basicis\Http\Message\StreamFactory;
use Basicis\View\View;
use Basicis\Basicis as App;

/**
 * Basicis Console class
 *
 * @category Basicis
 * @package  Basicis
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core
 */
class Console
{
    /**
     * $templates variable
     * @var string
     */
    private $templates = [__DIR__."/../storage/templates/"];

    /**
     * $options variable
     *
     * @var array
     */
    private $options = [
        "-c"  => "create",
        "-r"  => "remove",
        "-n"  => "namespace",
        "--namespace"  => "namespace",
        "--name"  => "class",
        "--class"  => "class",
        "-t"  => "table",
        "--table"  => "table",
        "-m"  => "model",
        "--model"  => "model",
        "--author.name"  => "author.name",
        "--author.email"  => "author.email",
        "--author.username"  => "author.username",
        "-p" => "namespace.path",
        "--path" => "namespace.path",
    ];

    /**
     * $commands variable
     *
     * @var array
     */
    private $commands = [
        [
            "name" => "help",
            "description" => "This Help page",
            "alias" => "--help",
            "options" => [],
        ],
        [
            "name" => "controller",
            "alias" => "-C",
            "description" => "Create, Remove or List Controllers",
            "options" => [
                "path",
                "namespace",
                "class",
                "create",
                "remove",
                "author.name",
                "author.email",
                "author.username",
                "link",
                "model"
            ],
            "namespace" => "App\Controllers",
            "path" => "src/controllers/"
        ],
        [
            "name" => "model",
            "alias" => "-M",
            "description" => "Create, Remove or List Models",
            "options" => [
                "path",
                "namespace",
                "class",
                "create",
                "remove",
                "author.name",
                "author.email",
                "author.username",
                "table",
                "link"
            ],
            "namespace" => "App\Models",
            "path" => "src/models/"
        ],
        [
            "name" => "middleware",
            "alias" => "-D",
            "description" => "Create, Remove or List Middleware",
            "options" => [
                "path",
                "namespace",
                "class",
                "create",
                "remove",
                "author.name",
                "author.email",
                "author.username",
                "link"
            ],
            "namespace" => "App\Middlewares",
            "path" => "src/middlewares/"
        ]
    ];

    /**
     * $colors variable
     *
     * @var array
     */
    private $colors = [
        "black" => "0;30",
        "dark_gray" => "1;30",
        "red" => "0;31",
        "bold_red" => "1;31",
        "green" => "0;32",
        "bold_green" => "1;32",
        "brown" => "0;33",
        "yellow" => "1;33",
        "blue" => "0;34",
        "bold_blue" => "1;34",
        "purple" => "0;35",
        "bold_purple" => "1;35",
        "cyan" => "0;36",
        "bold_cyan" => "1;36",
        "white" => "1;37",
        "bold_gray" => "0;37",
    ];

    /**
     * $args variable
     *
     * @var array
     */
    private $args = [];


    /**
     * Function __construct
     * Construct the console app with a array argument passed or null, to be passed in the `run()` method
     * @param array $argv
     * @param array $templatePaths
     */
    public function __construct(array $argv = null, array $templatePaths = null)
    {
        if ($argv !== null) {
            $this->args = $argv;
        }

        if ($templatePaths) {
            $this->templates = $templatePaths;
        }
    }


    /**
     * Function parse
     * Return a object with method/command name, action and data passed from cli $argv
     * @param array $argv
     *
     * @return object
     */
    private function parse(array $argv = null) : object
    {
        $command = $this->extractCommand($argv);
        $options = $this->extractOptions($command, $argv);
        $data = $this->extractData($command, $options);

        $action = null;
        if (isset($options["remove"])) {
            $action = "remove";
        }

        if (isset($options["create"])) {
            $action = "create";
        }

        if ($action === null) {
            $action = "list";
        }

        foreach ($data as $key => $value) {
            if (!in_array($key, $command["options"]) && $key !== "author") {
                unset($data[$key]);
            }
        }

        return (object) [
            "method" => $command["name"],
            "data" => $data,
            "action" => $action
        ];
    }


    /**
     * Function extractCommand
     * Return a array with command passed from cli $argv
     * @param array $argv
     *
     * @return array
     */
    private function extractCommand(array $argv = null) : array
    {
        $command = $this->commands[0];
        foreach ($this->commands as $com) {
            if (isset($argv[1]) && isset($com["name"]) | isset($com["alias"])) {
                if ($argv[1] === $com["name"] | $argv[1] === $com["alias"]) {
                    $command = $com;
                    break;
                }
            }
        }
        return $command;
    }


    /**
     * Function extractOptions
     * Return a array with options passed from cli $argv
     * @param array $command
     * @param array $argv
     *
     * @return array
     */
    private function extractOptions(array $command, array $argv = null) : array
    {
        $options = [];
        $argv = array_slice($argv, 1);
        foreach ($argv as $key => $arg) {
            if (array_key_exists($arg, $this->options) && isset($command["options"])) {
                if (isset($argv[$key+1]) && in_array($this->options[$arg], $command["options"])) {
                    $options[$this->options[$arg]] = $argv[$key+1];
                }
            }
        }
        return  $options;
    }


    /**
     * Function extractData
     * Return a array with data passed from cli $argv
     * @param array $command
     * @param array $options
     *
     * @return array
     */
    private function extractData(array $command, array $options) : array
    {
        $class = $options["create"] ?? $options["remove"] ?? "";
        $data = [
            "namespace" => $options["namespace"] ?? $command["namespace"] ?? "",
            "path" =>  $options["path"] ?? $command["path"] ?? "",
            "class" => $class,
            "table" => $options["tables"] ?? $class,
            "author" => [
                "name" => $options["author.name"] ?? "Jhon Snow",
                "email" => $options["author.email"] ?? "jhonshow@example.com",
                "username" => $options["author.username"] ?? "jhonshow"
            ],
            "link" => "https://github.com/{{author.username}}/<repository>/blob/<default-branch>/{{path}}"
        ];

        $data["path"] =  App::path().$data["path"];
        $data["class"] = $this->ucwords($data["class"]);
        $data["namespace"] = $this->ucwords($data["namespace"]);
        $data["table"] = strtolower($data["table"]);
        return $data;
    }


    /**
     * Function getTemplate
     * Get a file template by name
     * @param string $name
     * @param array $data
     *
     * @return String|null
     */
    private function getTemplate(string $name, array $data = []) : ?String
    {
        return (new View($this->templates))->getView($name, $data);
    }


    /**
     * Function createFile
     * Create a file with filename and text content and return boolean
     * @param string $filename
     * @param string $content
     *
     * @return bool
     */
    private function createFile(string $filename, string $content = "") : bool
    {
        $writed = 0;
        if (!file_exists($filename)) {
            $stream = (new StreamFactory)->createStreamFromFile($filename);
            if ($stream->isWritable()) {
                $writed = $stream->write($content);
            }
            $stream->close();
        }
        return ($writed > 0) && file_exists($filename);
    }


    /**
     * Function removeFile
     * Remove a file by name and return boolean
     * @param string $filename
     *
     * @return bool
     */
    private function removeFile(string $filename) : bool
    {
        if (file_exists($filename)) {
            return unlink($filename);
        }
        return false;
    }


    /**
     * Function ucwords
     * Separate a string and normalize this
     * @param string $text
     *
     * @return string
     */
    private function ucwords(string $text) : string
    {
        return str_replace("^", "", ucwords(str_replace(["-", "_"], ["^"], $text), "^"));
    }


    /**
     * Function color
     * Colors the past text according to the specific color in the first argument
     * @param string $name
     * @param string $text
     *
     * @return string
     */
    public function color(string $name, string $text) : string
    {
        if (array_key_exists($name, $this->colors)) {
            return "\033[".$this->colors[$name]."m".$text."\033[0m";
        }
        return $text;
    }


    /**
     * Function help
     * Displays help text
     * @return void
     */
    public function help()
    {
        echo $this->color("purple", "\nBasicis - Maker\n\n");
        echo $this->color("white", "Use Mode: \n");
        echo $this->color("grey", "\n $ maker ".
        $this->color("cyan", "<command>").
        " [<classname> ".$this->color("bold_blue", "<option>")." <option-value> ... ]\n");
        
        echo $this->color("white", "\nCommands:\n");
        foreach ($this->commands as $command) {
            echo " ".   $this->color("cyan", $command['name']). " : "
            .$this->color("grey", ($command['description'] ?? ucfirst($command['name'])))."\n";
        }

        echo $this->color("bold_blue", "\nOptions: \n");
        foreach ($this->options as $opKey => $option) {
            $option = ucwords(str_replace(".", " ", $option), " ");
            echo " ". $this->color("bold_blue", $opKey). "  <value> : ". $this->color("grey", $option)."\n";
        }
        echo "\n";
        return;
    }


    /**
     * Function controller
     * List, create and remove controllers
     * @param string $action
     * @param array $data
     *
     * @return void
     */
    public function controller(string $action = null, array $data = [])
    {
        switch ($action) {
            case 'create':
                $this->create("Controller", $data);
                break;

            case 'remove':
                $this->remove("Controller", $data);
                break;
            
            default:
                $this->list("Controllers", $data["path"]);
                break;
        }
    }


    /**
     * Function model
     * List, create and remove models
     * @param string $action
     * @param array $data
     *
     * @return void
     */
    public function model(string $action = null, array $data = [])
    {
        switch ($action) {
            case 'create':
                $this->create("Model", $data);
                break;

            case 'remove':
                $this->remove("Model", $data);
                break;
            
            default:
                $this->list("Models", $data["path"]);
                break;
        }
    }


    /**
     * Function middleware
     * List, create and remove middlewares
     * @param string $action
     * @param array $data
     *
     * @return void
     */
    public function middleware(string $action = null, array $data = [])
    {
        switch ($action) {
            case 'create':
                $this->create("Middleware", $data);
                break;

            case 'remove':
                $this->remove("Middleware", $data);
                break;
            
            default:
                $this->list("Middlewares", $data["path"]);
                break;
        }
    }


    /**
     * Function list
     * List files of a specified type
     * @param string $fileType
     * @param string $path
     *
     * @return void
     */
    public function list(string $fileType, string $path)
    {
        echo $this->color("purple", "\nBasicis - $fileType \n\n");
        $files = glob($path);
        if (count($files) > 0) {
            foreach (glob($path."*.php") as $file) {
                echo $this->color("green", " ✔ ".str_replace(".php", "", basename($file))."\n");
            }
            echo "\n";
            return;
        }
        echo $this->color("red", " ⊘ $fileType Not found! \n\n");
    }


    /**
     * Function create
     * Create files of a specified type
     * @param string $fileType
     * @param array $data
     *
     * @return bool
     */
    private function create(string $fileType, array $data = []) : bool
    {
        echo $this->color("purple", "\nBasicis - Create $fileType \n\n");
        $filename = sprintf(
            "%s%s.%s",
            $data["path"],
            $data["class"],
            "php"
        );
        
        $content = $this->getTemplate(
            strtolower($fileType),
            $data
        );

        if ($this->createFile($filename, $content)) {
            echo $this->color("green", " ✔ Created $fileType "
            .str_replace(".php", "", basename($filename)))
            ." --> ".$filename."\n";
            return true;
        }
        echo $this->color("red", " ⊘ Error on create $fileType ".str_replace(".php", "", basename($filename))." \n");
        return false;
    }


    /**
     * Function remove
     * Create files of a specified type
     * @param string $fileType
     * @param array $data
     *
     * @return bool
     */
    private function remove(string $fileType, array $data = []) : bool
    {
        echo $this->color("purple", "\nBasicis - Remove $fileType \n\n");
        $filename = sprintf(
            "%s%s.%s",
            $data["path"],
            $data["class"],
            "php"
        );
        if ($this->removeFile($filename)) {
            echo $this->color("green", " ✔ Removed $fileType ".str_replace(".php", "", basename($filename))." \n");
            return true;
        }
        echo $this->color("red", " ⊘ Error on Removing $fileType ".str_replace(".php", "", basename($filename))." \n");
        return false;
    }


    /**
     * Function run
     * Run the app console with a past or null argument,
     * so arguments previously passed in the constructor method will be used
     * @param array $argv
     *
     * @return void
     */
    public function run(array $argv = null)
    {
        $parse = $this->parse($argv ?? $this->args);
        $method = $parse->method;

        if (method_exists($this, $parse->method) && $parse->method !== "help") {
            $method = $parse->method;
            return $this->$method($parse->action, $parse->data);
        }
        $this->help();
    }
}
