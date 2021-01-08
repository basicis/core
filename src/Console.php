<?php
namespace Basicis;

use Basicis\Exceptions\RuntimeException;
use Basicis\Http\Message\StreamFactory;
use Basicis\View\View;
use Basicis\Basicis as App;

/**
 * Basicis\Console class affectionately called Maker
 *
 * ## Get Started:
 * ```
 *  maker <command> [<option> <option-value> ... ]
 * ```
 *
 * - Obs: The characters "-" (dash) or "_" (underline) indicate that the following
 * letter must be capitalized when creating class.
 *
 * List all controllers files
 * ```
 *  maker controller -l
 * ```
 *
 * Create a new controller file named `test`
 * ```
 *  maker controller -c test
 * ```
 *
 * Create a new controller alias with command alias `-C`, namespace and model params `model-test`
 * ```
 *  maker -C -c test -m model-test -n "App\Controllers"
 * ```
 *
 * Create a new model file
 * ```
 *  maker model -c ModelTest
 * ```
 *
 * Create a new model alias with command alias `-M`, namespace and model params
 * ```
 *  maker -M -c model-test --namesapace "App\Models"
 * ```
 *
 * ### Commands:
 * | Name | Alias | Description |
 * |------|-------|-------------|
 * | help | * | This Help page |
 * | controller | -C | Remove or List Controllers |
 * | model | -M | Create, Remove or List Models |
 * | middleware | -D | Create, Remove or List Middleware |
 *
 *
 * ### Options:
 * | Name | Alias | Description | Value required |
 * |------|-------|-------------|----------------|
 * | -l | | List all classes Controllers, Models or Middlewares | none |
 * | -c | | Create | classname : string |
 * | -r | | Remove | classname : string |
 * | -n | --namesapace | Namespace | namespace : string |
 * | --class | --name | Class Name | class : string |
 * | -t | --table | Table name for model command | table : string |
 * | -m | --model | Model name for controller command | model : string |
 * | -p | --path | Namespace path | path : string |
 * | --author.name |  | Author Name | name : string |
 * | --author.email |  | Author Email | email : string |
 * | --author.username |  | Author Username | username : string |
 * | --link |  | File vendor Link | link : string |
 *
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
        "-l" => "list",
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
        "--link" => "link",
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
                "model",
                "list"
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
                "link",
                "list"
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
                "link",
                "list"
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
     * $bgColors variable
     *
     * @var array
     */
    private $bgColors = [
        "black" => "0;40",
        "dark_gray" => "1;40",
        "red" => "0;41",
        "bold_red" => "1;41",
        "green" => "0;42",
        "bold_green" => "1;42",
        "brown" => "0;44",
        "yellow" => "1;43",
        "blue" => "0;44",
        "bold_blue" => "1;44",
        "purple" => "0;35",
        "bold_purple" => "1;45",
        "cyan" => "0;46",
        "bold_cyan" => "1;46",
        "white" => "1;47",
        "bold_gray" => "0;47",
        "none" => ""
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
            $stream = null;
            try {
                $stream = (new StreamFactory)->createStreamFromFile($filename);
            } catch (RuntimeException $e) {
                mkdir(pathinfo($filename, PATHINFO_DIRNAME), 0775, true);
                $stream = (new StreamFactory)->createStreamFromFile($filename);
            }

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
            $removed = unlink($filename);
            $path = pathinfo($filename, PATHINFO_DIRNAME);
            
            if ($removed && count(glob($path."/*")) === 0) {
                return $removed && rmdir($path);
            }
            return $removed;
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
    private function color(string $name, string $text) : string
    {
        if (array_key_exists($name, $this->colors)) {
            return "\033[".$this->colors[$name]."m".$text."\033[0m";
        }
        return $text;
    }

    /**
     * Function colors
     * Colors the past text according to the specific colors in the first argument
     *
     * @param string $text
     * @param string $color
     * @param string $bgColor
     *
     * @return string
     */
    private function colors(string $text, string $color = "white", string $bgColor = "none") : string
    {
        if (array_key_exists($color, $this->colors) && array_key_exists($bgColor, $this->bgColors)) {
            return "\033[".$this->colors[$color].";".$this->bgColors[$bgColor]."m".$text."\033[0m";
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
        echo "\n"
        .$this->colors(
            "Basicis - Maker",
            "white",
            "blue"
        )
        ."\n\n"
        .$this->color("white", "Use Mode: ")
        ."\n\n"
        .$this->color("grey", " maker "
        .$this->color("cyan", "<command>")
        ."[".$this->color("bold_blue", "<option>")
        ." <value>")." ...]"
        ."\n\n"
        .$this->color("white", "\nCommands:")."\n";

        foreach ($this->commands as $command) {
            echo " ".   $this->color("cyan", $command['name']). " : "
            .$this->color("grey", ($command['description'] ?? ucfirst($command['name'])))
            ."\n";
        }

        echo "\n"
        .$this->color("bold_blue", "Options: ")
        ."\n";

        foreach ($this->options as $opKey => $option) {
            $option = ucwords(str_replace(".", " ", $option), " ");
            $line = " "
            .$this->color("bold_blue", $opKey);

            if ($opKey !== "-l") {
                $line .= "  <value>";
            }
            $line .= " : ".$this->color("grey", $option)."\n";

            echo $line;
        }
        echo "\n";
        return;
    }


    /**
     * Function $data["fileType"]
     * Exec List, create and remove by $data["fileType"]
     *
     * @param string $action
     * @param array $data
     *
     * @return void
     */
    public function exec(string $action = null, array $data = [])
    {
        switch ($action) {
            case 'create':
                $this->create($data);
                break;

            case 'remove':
                $this->remove($data);
                break;
            
            default:
                $this->list($data["fileType"] ?? "", $data["path"]);
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
        echo "\n"
        .$this->colors(
            "Basicis - Maker | List all $fileType",
            "white",
            "blue"
        )
        ."\n\n";
        
        $files = glob($path);
        if (count($files) > 0) {
            foreach (glob($path."*.php") as $file) {
                echo $this->color("green", " ✔ ".str_replace(".php", "", basename($file)))
                ."\n";
            }
            echo "\n";
            return;
        }
        echo $this->color("red", " ⊘ $fileType Not found!")."\n\n";
    }


    /**
     * Function create
     * Create files of a specified type
     *
     * @param array $data
     *
     * @return bool
     */
    private function create(array $data = []) : bool
    {
        echo "\n"
        .$this->colors(
            "Basicis - Maker | Create ".$data["fileType"],
            "white",
            "blue"
        )
        ."\n\n";

        $filename = sprintf(
            "%s%s.%s",
            $data["path"],
            $data["class"],
            "php"
        );
        
        $content = $this->getTemplate(
            strtolower($data["fileType"]),
            $data
        );

        if (file_exists($filename)) {
            echo $this->colors(
                " ✔ File "
                .str_replace(".php", "", basename($filename))." already exists!",
                "white",
                "red"
            )
            ."\n";
            return false;
        }

        if ($this->createFile($filename, $content ?? "")) {
            echo $this->color("green", " ✔ Created ".$data["fileType"]." "
            .str_replace(".php", "", basename($filename)))
            ." --> ".$filename."\n";
            return true;
        }

        echo $this->color(
            "red",
            " ⊘ Error on create "
            .$data["fileType"]." "
            .str_replace(".php", "", basename($filename))
            ." \n"
        );
        return false;
    }


    /**
     * Function remove
     * Create files of a specified type
     *
     * @param array $data
     *
     * @return bool
     */
    private function remove(array $data = []) : bool
    {
        echo "\n"
        .$this->colors(
            "Basicis - Maker | Create ".$data["fileType"],
            "white",
            "blue"
        )
        ."\n\n";

        $filename = sprintf(
            "%s%s.%s",
            $data["path"],
            $data["class"],
            "php"
        );

        if (!file_exists($filename)) {
            echo $this->colors(
                " ⊘ Error, file "
                .str_replace(".php", "", basename($filename))." no exists!",
                "white",
                "red"
            )
            ."\n";
            return false;
        }

        $line = readline(
            "Do you really want to remove the ".$data["fileType"]." "
            .str_replace(".php", "", $this->color("blue", basename($filename)))."? ["
            .$this->color("green", "yes")." or "
            .$this->color("red", "no")."]: "
        );

        if (strtolower($line) === "yes" | str_starts_with(strtolower($line), "y")) {
            if ($this->removeFile($filename)) {
                echo $this->color(
                    "green",
                    " ✔ Removed file "
                    .$data["fileType"]." "
                    .str_replace(".php", "", basename($filename))
                    ." \n"
                );
                return true;
            }

            echo $this->color(
                "red",
                " ⊘ Error on Removing "
                .$data["fileType"]." "
                .str_replace(".php", "", basename($filename))
                ." \n"
            );
        }

        return false;
    }


    /**
     * Function hasCommand
     * Check if a command exists
     *
     * If except $name is equals "help", for this return only false
     * @param string $name
     *
     * @return bool
     */
    private function hasCommand(string $name) : bool
    {
        foreach ($this->commands as $key => $command) {
            $exists = ((isset($command["name"]) && ($command["name"] === $name)) |
                        (isset($command["alias"]) && ($command["alias"] === $name)));
            if ($exists && $name !== "help") {
                return true;
            }
        }
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

        if ($this->hasCommand($parse->method)) {
            $parse->data["fileType"] = ucfirst($parse->method);
            return $this->exec($parse->action, $parse->data);
        }

        return $this->help();
    }
}
