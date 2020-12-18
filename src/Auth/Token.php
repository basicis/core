<?php
namespace Basicis\Auth;

use \Firebase\JWT\JWT;

/**
 * Token Class
 * Basicis default Token class
 *
 * @category Basicis\Auth
 * @package  Basicis\Auth
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Basicis/Auth/Token.php
 */
class Token
{
    /**
     * $appKey variable
     *
     * @var string
     */
    private $appKey;

    /**
     * $iss variable
     *
     * @var string
     */
    private $iss;

    /**
     * $exp variable
     *
     * @var int
     */
    private $exp;

    /**
     * $nbf variable
     *
     * @var int
     */
    private $nbf;

    /**
     * $nbf variable
     *
     * @var int
     */
    private $iat;


    /**
     * $encoded variable
     *
     * @var string
     */
    private $encoded;


    /**
     * $decoded variable
     *
     * @var object
     */
    private $decoded;



    /**
     * Function __construct
     *
     * @return void
     * 
     * @param AuthInterface $user
     * @param string        $appKey
     * @param string        $expiration
     * @param string        $nobefore
     */
    public function __construct(
        string $appKey,
        string $iss = "", 
        string $expiration = "+30 minutes",
        string $nobefore = "now"
    ) {
        $this->appKey = $appKey;
        $this->iss = $iss;
        $this->iat = (new \DateTime("now"))->getTimestamp();
        $this->nbf = (new \DateTime($nobefore))->getTimestamp();
        $this->exp = ($this->nbf + (new \DateTime($expiration))->getTimestamp()) - $this->iat;
    }



    /**
     * Function create
     * Receive an instance of AuthInterface user and Creating a token
     *
     * @param  AuthInterface     $user
     * @param  array|string|null $data
     * @return string|null
     */
    public function create(AuthInterface $user, $data = null) : ?string
    {
        $token = array(
            "iss" => $this->iss,
            "iat" => $this->iat,
            "nbf" => $this->nbf,
            "exp" => $this->exp,
            "usr" => [
                "id" => $user->getId(),
                "username" => $user->getUsername(),
                "role" => $user->getRole()
            ]
        ); 

        if ($data !== null) {
            $token["dat"] = $data;
        }
        return $this->encode($token); 
    }


    /** 
     * Function check
     * Checking a token
     *
     * @param  string $token
     * @return boolean  
     */
    public function check(string $token)
    {
        $tokenDecoded = $this->decode($token);
        if ($tokenDecoded) {
            return ((new \DateTime("now"))->getTimestamp() >= $tokenDecoded->nbf) && ($tokenDecoded->exp > (new \DateTime("now"))->getTimestamp()) ? true : false;
        } 
        return false;
    }


    /** 
     * Function renew
     * Renew a Token, optionaly set any data type of string, array or null
     *
     * @param  string            $token
     * @param  string            $expiration
     * @param  string            $nobefore
     * Parse about any English textual datetime description into a Unix timestamp
     * https://www.php.net/manual/en/function.strtotime
     * @param  string|array|null $data
     * @return string|null  
     */
    public function renew(
        string $token,
        string $expiration = "+30 minutes",
        string $nobefore = "now",
        $data=null
    ) : ?string {

        $this->nbf = (new \DateTime($nobefore))->getTimestamp();
        $this->exp = $this->nbf + (new \DateTime($expiration))->getTimestamp();

        if ($this->check($token)) {
            $tokenDecode =  $this->decode($token);

            if ($tokenDecode) {
                $tokenDecode->iat = $this->iat;
                $tokenDecode->nbf = $this->nbf;
                $tokenDecode->exp = $this->exp;

                if (!is_null($data) ) {
                    $tokenDecode->dat = $data;
                }
                return $this->encode((array) $tokenDecode);
            } 
        }
        return null;
    }


    /** 
     * Function Encode Token
     * Enconding a Token
     *
     * @param  array $token
     * @return string  
     */
    public function encode(array $token) : ?string
    {
        if (isset($token) && is_array($token)) {
            return JWT::encode($token, $this->appKey); 
        }
        return null;
    }


    /**
     * Function Decode Token
     *
     * @param  string $token
     * @return object|null
     * @throws \Exception
     */
    public function decode(string $token) : ?object
    {
        if (isset($token) && (count(explode('.', $token)) == 3)) {
            try {
                return JWT::decode($token, $this->appKey, array('HS256'));
            } catch(\Exception $e) {
            }
        }
        return null;
    }

}