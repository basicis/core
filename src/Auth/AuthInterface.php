<?php
namespace Basicis\Auth;

use Basicis\Basicis as App;

/**
 * AuthInterface, all Auth classes implements from this
 *
 * @category Basicis/Auth
 * @package  Basicis/Auth
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Auth/AuthInterface.php
 */
interface AuthInterface
{
    /**
     * Function getId
     * Return self id
     *
     * @return mixed
     */
    public function getId() : ?int;

    /**
     * Function getUsername
     * Return self username
     *
     * @return string
     */
    public function getUsername() : ?string;

    /**
     * Function getRole
     * Return self role
     *
     * @return int
     */
    public function getRole() : int;
}
