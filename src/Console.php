<?php
namespace Basicis;

use Basicis\Http\Message\StreamFactory;

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
     * $resourceInput variable
     * @var string
     */
    private $resourceInput = "php://input";

    public function __construct(array $argv = null)
    {
        if ($argv !== null) {
            var_dump($argv);
        }
    }

    public function command(string $command, array $args = null)
    {
        var_dump($command, $args);
    }
}
