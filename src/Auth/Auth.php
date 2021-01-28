<?php
namespace Basicis\Auth;

use Psr\Http\Message\ServerRequestInterface;
use Doctrine\ORM\Mapping as ORM;
use Basicis\Model\Model;

/**
 * Auth Class
 * Basicis default authentication class
 * @category Basicis\Auth
 * @package  Basicis\Auth
 * @author   Messias Dias <https://github.com/messiasdias> <messiasdias.ti@gmail.com>
 * @license  https://opensource.org/licenses/MIT MIT License
 * @link     https://github.com/basicis/core/blob/master/src/Basicis/Auth/Auth.php
 *
 */
class Auth
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
     * Function function
     * Check  Auth User and return a string token of on success or null in error case
     * @param ServerRequestInterface $request
     * @param array $findBy - Array find user by arguments
     * @param string $passKey - Auth password key
     * @param string $appKey - Basicis AppKey
     * @param string $expiration - Expires at specified monent
     * @param string $nobefore - No use Before of this moment
     * @return string|null
     */
    public static function login(
        ServerRequestInterface $request,
        AuthInterface $user
    ) : ?string {
        if ($user instanceof AuthInterface) {
            $token = new Token(
                $request->getAttribute("appKey"),
                $request->getAttribute("tokenIss"),
                $request->getAttribute("tokenExpiration"),
                $request->getAttribute("tokenNobefore")
            );
            return $token->create($user);
        }
        return null;
    }


    /**
      * Function getUser
      * Get a Auth User by ServerRequestInterface
      *
      * @param ServerRequestInterface $request
      * @param string|null $authClass
      *
      * @return AuthInterface|null
      */
    public static function getUser(ServerRequestInterface $request, string $authClass = null) : ?AuthInterface
    {
        if ($authClass === null) {
            $authClass = self::class;
        }

        if (new $authClass instanceof AuthInterface && isset($request->getHeader('authorization')[0])) {
            $token = $request->getHeader('authorization')[0];
            $tokenObj = new Token($request->getAttribute("appKey"));
            if ($tokenObj->check($token)) {
                $user = $authClass::findOneBy(["id" => $tokenObj->decode($token)->usr->id]);
                if ($user === null) {
                    $user = $authClass::findOneBy(["username" => $tokenObj->decode($token)->usr->username]);
                }
                return $user;
            }
        }
        return null;
    }
}
