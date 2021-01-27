<?php
namespace Basicis\Auth;

use Basicis\Basicis as App;
use Basicis\Model\ModelInterface;

/**
 * AuthInterface, all Auth classes implements from this
 *
 * @category Basicis/Auth
 * @package  Basicis/Auth
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Auth/AuthInterface.php
 */
interface AuthInterface extends ModelInterface
{
    /**
     * Function getId
     * Return self id
     * @return mixed
     */
    public function getId() : ?int;

    /**
     * Function getUsername
     * Return self username
     * @return string|null
     */
    public function getUsername() : ?string;

    /**
     * Function setUsername
     * Return a instance of ModelInterface
     * @return AuthInterface
     */
    public function setUsername(string $username) : AuthInterface;

    /**
     * Function getEmail
     * Return self email
     * @return string|null
     */
    public function getEmail() : ?string;

    /**
     * Function setEmail
     * Return a instance of ModelInterface
     * @return AuthInterface
     */
    public function setEmail(string $email) : AuthInterface;

    /**
     * Function getRole
     * Return self role
     * @return int|null
     */
    public function getRole() : int;

    /**
     * Function getRoleName
     * Get role permission Name
     *
     * @return string|null
     */
    public function getRoleName() : ?string;


     /**
     * Function setRole
     * Set role permission ID includes is Default roles permissions IDs 'DEFAULT_ROLES' or optional > 5
     * @param int $roleId
     * @return AuthInterface
     */
    public function setRole(int $roleId) : AuthInterface;


    /**
     * Function checkPass
     * Check Auth password key
     * @param string $passKey
     * @return bool
     */
    public function checkPass(string $passKey) : bool;
}
