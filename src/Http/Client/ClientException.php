<?php
namespace Basicis\Http\Client;

use Psr\Http\Client\ClientExceptionInterface;
use Basicis\Http\Message\Request;
use Basicis\Exceptions\BasicisException;

/**
 * ClientException class
 * Every HTTP client related exception MUST implement this interface.
 * - ClientException extends Basicis\Core\Exception
 *
 * @category Basicis/Http/Client
 * @package  Basicis/Http/Client
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Http/Client/ClientException.php
 **/
class ClientException extends BasicisException implements ClientExceptionInterface
{
    /**
     * $request variable
     *
     * @var Request
     */
    protected $request;

    /**
     * Function setRequest
     *
     * @param Request $request
     * @return ClientException
     */
    public function setRequest(Request $request) : ClientException
    {
        $this->request = $request;
        return $this;
    }
}
