<?php
namespace Basicis\Auth;

use Doctrine\ORM\Mapping as ORM;
use Basicis\Model\Model;
use Basicis\Core\Validator;

/**
 * Auth Class
 * Basicis default authentication class
 * @category Basicis\Auth
 * @package  Basicis\Auth
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Basicis/Auth/Auth.php
 * @ORM\Entity
 * @ORM\Table(name="Auth")
 */
class Auth extends Model implements AuthInterface
{

    /**
     *  DEFAULT_ROLES
     *  Default roles permissions IDs
     * @var string
     */
    const DEFAULT_ROLES = [
        0 => "system",
        1 => "god",
        2 => "admin",
        3 => "manager",
        4 => "client",
        5 => "user"
    ];

    /**
     * $username variable
     * @ORM\Column(name="username", length=300, unique=true)
     * @var string
     */
    protected $username;

    /**
     * $email variable
     * @ORM\Column(name="email", length=300, unique=true)
     * @var string
     */
    protected $email;

    /**
     * $pass variable
     * @ORM\Column(name="pass", length=60, unique=true)
     * @var string
     */
    protected $pass;


    /**
     * $role variable
     * @ORM\Column(name="role", type="integer")
     * @var int
     */
    protected $role;


    /**
     * $protecteds variable
     *
     * @var array
     */
    protected $protecteds = ["pass"];


    /**
     * Function __construct
     * Run parent Basicis\Model\Model::__construct method with $data [array|int(id)] as argument
     * @param array|int $data
     */
    public function __construct($data = null)
    {
        parent::__construct($data);
    }

    /**
     * Function getUsername
     * Get Auth username key
     *
     * @return string|null
     */
    public function getUsername() : ?string
    {
        return $this->username;
    }


    /**
     * Function setUsername
     * Set Auth username key
     * @param string $username
     *
     * @return Auth
     */
    public function setUsername(string $username) : Auth
    {
        $this->username = $username;
        return $this;
    }



    /**
     * Function getEmail
     * Get Auth email key
     *
     * @return string|null
     */
    public function getEmail() : ?string
    {
        return $this->email;
    }


    /**
     * Function setEmail
     * Set Auth email key
     * @param string $email
     *
     * @return Auth
     */
    public function setEmail(string $email) : Auth
    {
        if(Validator::validate($email, "email")) { 
            $this->email = $email;
            if ($this->getUsername() === null) {
                $this->setUsername($email);
            }
        }
        return $this;
    }


    /**
     * Function setPass
     * Set Auth password key
     * @param string $passKey
     *
     * @return Auth
     */
    public function setPass(string $passKey) : Auth
    {
        $this->pass = password_hash($passKey, PASSWORD_BCRYPT);
        return $this;
    }



    /**
     * Function checkPass
     * Check Auth password key
     * @param string $passKey
     *
     * @return bool
     */
    public function checkPass(string $passKey) : bool
    {
        return password_verify($passKey, $this->pass);
    }



    /**
     * Function getRole
     * Get role permission ID 
     * @return int
     */
    public function getRole() : int
    {
        return $this->role !== null ? $this->role : 5;
    }


    /**
     * Function getRoleName
     * Get role permission Name
     * 
     * @return string|null
     */
    public function getRoleName() : ?string
    {
        if (array_key_exists($this->getRole(), self::DEFAULT_ROLES)) {
            return self::DEFAULT_ROLES[$this->getRole()];
        }
        return null;
    }


    /**
     * Function setRole
     * Set role permission ID includes is Default roles permissions IDs 'DEFAULT_ROLES' or optional > 5
     * @param int $roleId
     *
     * @return Auth
     */
    public function setRole(int $roleId) : Auth
    {
        if (array_key_exists($roleId, self::DEFAULT_ROLES) | (int) $roleId > 5) {
            $this->role = $roleId;
        }
        return $this;
    }


    /**
     * Function function
     * Check  Auth User and return a string token of on success or null in error case
     * @param string $username
     * @param string $passKey
     * @param string $appKey
     *
     * @return string|null
     */
    public static function login(
      string $username,
      string $passKey,
      string $appKey,
      string $iss = ""
    ) : ?string {

        $user = self::findOneBy(['username' => $username]);
        if($user === null)  {
            $user = self::findOneBy(['email' => $username]);
        }

        $entityClass = get_called_class();
        if (($user instanceof $entityClass) && $user->checkPass($passKey)) {
          $token = new Token($appKey, $iss, "+30 minutes", "now");
          return $token->create($user);
        }
        return null;
    }


    /**
     * Function getUser
     * Get a Auth User by token and appKey
     * @param string $token
     *
     * @return Auth|null
     */
    public static function getUser(string $token, string $appKey) : ?Auth
    {
        $tokenObj = new Token($appKey);
        if ($tokenObj->check($token)) {
          $user = self::findOneBy(["id" => $tokenObj->decode($token)->usr->id]);
          if ($user === null) {
              $user = self::findOneBy(["username" => $tokenObj->decode($token)->usr->username]);
          }
          return $user; 
        }
        return null;
    }
}