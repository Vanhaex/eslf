<?php

namespace Framework\Middlewares;

use Framework\InputUtility;
use Framework\SessionUtility;
use Framework\View;
use Smarty;

/**
 * Generate and verify CSRF tokens against CSRF attacks
 */
class VerifyCSRFMiddleware
{
    private static Smarty $smarty;

    private static string $csrf_token_name = "csrf_token";

    private static int $csrf_token_lifetime = 3*60*60;

    /**
     * Lance ce qui va être executé par le Middleware
     *
     * @return void
     * @throws \Exception
     */
    public static function execute()
    {
        // Trying to verofy if CSRF token is correct in the form
        try{
            self::verifyToken(InputUtility::request_method());
        }
        catch (\Exception $e){}

        // Generating CSRF token
        $token = self::generateToken(self::$csrf_token_name);

        // Let's assign it to input in form
        self::$smarty = View::initView();

        self::$smarty->assign('csrf_token', $token);
    }

    /**
     * Generating CSRF token
     *
     * @param $input
     * @return false|string
     * @throws \Exception
     */
    private static function generateToken($input)
    {
        // We nee to precise input name and session (identical)
        if (empty($input)){
            return false;
        }

        $token = base64_encode(time() . sha1(InputUtility::ip()) . random_bytes(32));

        SessionUtility::getInstance()->setSession($input, $token);

        return $token;
    }

    /**
     * Verify if token exist and is in the form
     *
     * @param $method
     * @throws \Exception
     */
    private static function verifyToken($method)
    {
        if ($method === "POST"){
            if (InputUtility::request('post', 'csrf_token')){
                self::checkToken('csrf_token', InputUtility::request('post', 'csrf_token'), self::$csrf_token_lifetime);
            }
            else{
                View::error500("CSRF token don't exists");
            }
        }
    }

    /**
     * Verify if token given in input is the same than session token
     *
     * @param string $session_token name of session variable
     * @param string $token value of input
     * @param float|int $timeout max duration of token (default 3 hours)
     * @throws \Exception
     */
    private static function checkToken(string $session_token, string $token, $timeout = null)
    {
        if (!$token){
            View::error500("CSRF token is invalid");
        }

        $sessionToken = SessionUtility::getInstance()->getSession($session_token);

        if (!$sessionToken){
            View::error500("CSRF session token is invalid");
        }

        if ($token !== $sessionToken){
            View::error500("CSRF token is different than session token");
        }

        // Let's verify if CSRF token has expired
        if (is_int($timeout) && (intval(substr(base64_decode($sessionToken), 0, 10)) + $timeout) < time()){
            View::error500("CSRF token has expired");
        }
    }
}
