<?php
namespace Basicis\Auth;

use \Firebase\JWT\JWT;
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
 * @ORM\MappedSuperclass
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
     * @ORM\@Column(name="username", length=300, unique=true)
     * @var string
     */
    protected $username;

    /**
     * $email variable
     * @ORM\@Column(name="email", length=300, unique=true)
     * @var string
     */
    protected $email;

    /**
     * $pass variable
     * @ORM\@Column(name="pass", length=300, unique=true)
     * @var string
     */
    protected $pass;


    /**
     * $role variable
     * @ORM\@Column(name="role", type="integer")
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
     *
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
     * @return string
     */
    public function getUsername() : string
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
        //if(Validator::validate($username, "noExists:".get_called_class())) { 
            $this->username = $username;
        //}
        return $this;
    }



    /**
     * Function getEmail
     * Get Auth email key
     *
     * @return string
     */
    public function getEmail() : string
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
      if(Validator::validate($username, "email")) { 
         $this->email = $email;
      }
      return $this;
    }


    /**
     * Function setPass
     * Set Auth password key
     * @param string $pass
     *
     * @return Auth
     */
    public function setPass(string $pass) : Auth
    {
        $this->pass = $pass;
        if (count_chars($this->pass) !== 60) {
          $this->pass = password_hash($pass, PASSWORD_BCRYPT);
        }
        return $this;
    }


    /**
     * Function getRole
     * Get role permission ID 
     * @return string
     */
    public function getRole() : int
    {
      return $this->role ?? 5;
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
        if (in_array($roleId, self::DEFAULT_ROLES) | (int) $roleId > 5) {
            $this->role = $roleId;
        }
        return $this;
    }


    /**
     * Function checkPass
     * Check Auth password key
     * @param string $pass
     *
     * @return bool
     */
    public function checkPass(string $pass) : bool
    {
        return password_verify($pass, $this->pass);
    }


    /**
     * Function function
     *
     * @param string $username
     * @param string $passKey
     * @param string $appKey
     *
     * @return string|null
     */
    public static function login(
      string $username,
      string $passKey,
      string $appKey = ""
    ) : ?string {
        $user = self::findOneBy(['username' => $username]);
        if($user === null)  {
            $user = self::findOneBy(['email' => $username]);
        }

        if ($user instanceof Auth && $user->checkPass($passKey)) {
            return Token::create($user, "+30 minutes", $appKey);
        }
        return null;
    }


    /**
     * Function getUser
     *
     * @param string $token
     *
     * @return void
     */
    public function getUser(string $token)
    {
        if (Token::check($token)) {
          return self::find((int) Token::decode($token)->usr->id); 
        }
    
        return null;
    }
}