<?php
namespace Basicis\Auth;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManager;
use Basicis\Model\Model;
use Basicis\Core\Validator;
use Basicis\Basicis as App;

/**
 * User class
 * @ORM\MappedSuperclass
 * @ORM\Entity
 */
class User extends Model implements AuthInterface
{
    /**
     * $protecteds variable
     * Protecteds propreties
     * @var array
     */
    protected $protecteds = ["pass"];

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
     * $role variable
     * @ORM\Column(name="role", type="integer")
     * @var int
     */
    protected $role;

    /**
     * @ORM\Column(name="firstName", type="string")
     * @var string $firstName
     */
    protected $firstName;

    /**
      * @ORM\Column(name="lastName", type="string")
      * @var string $lastName
      */
    protected $lastName;

     /**
     * $pass variable
     * @ORM\Column(name="pass", length=60)
     * @var string
     */
    protected $pass;

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
     * Get User username
     * @return string|null
     */
    public function getUsername() : ?string
    {
        return $this->username;
    }

    /**
     * Function setUsername
     * Set User username
     * @param string $username
     * @return User
     */
    public function setUsername(string $username) : User
    {
        $this->username = $username;
        return $this;
    }


    /**
     * Function setEmail
     * Set User email
     * @param string $email
     * @return User
     */
    public function setEmail(string $email) : User
    {
        if (Validator::validate($email, "email")) {
            $this->email = $email;

            if ($this->getUsername() === null) {
                $this->setUsername($email);
            }
        }
        return $this;
    }

    /**
     * Function getEmail
     * Get User email
     * @return string|null
     */
    public function getEmail() : ?string
    {
        return $this->email;
    }

    /**
     * Function setPass
     * Set User password key
     * @param string $passKey
     * @return User
     */
    public function setPass(string $passKey) : User
    {
        $this->pass = password_hash($passKey, PASSWORD_BCRYPT);
        return $this;
    }

    /**
     * Function checkPass
     * Check User password key
     * @param string $passKey
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
     * @return User
     */
    public function setRole(int $roleId) : User
    {
        if (array_key_exists($roleId, self::DEFAULT_ROLES)) {
            $this->role = $roleId;
        }
        return $this;
    }

    /**
     * Function getFirstName
     * Get user first name
     *
     * @return string
     */
    public function getFirstName() : string
    {
        return $this->firstName;
    }

    /**
     * Function setFirstName
     * Set user first name
     *
     * @param string $firstName
     *
     * @return User
     */
    public function setFirstName(string $firstName) : User
    {
        $this->firstName = ucfirst($firstName);
        return $this;
    }

    /**
     * Function getLastName
     * Get user last name
     *
     * @return string
     */
    public function getLastName() : string
    {
        return $this->lastName;
    }

    /**
     * Function setLastName
     * Set user last name
     *
     * @param string $lastName
     *
     * @return User
     */
    public function setLastName(string $lastName) : User
    {
        $this->lastName = ucfirst($lastName);
        return $this;
    }
}
