<?php

namespace Framework\Middlewares;

use Framework\InputUtility;
use Framework\SessionUtility;
use Framework\View;
use Smarty;

/**
 * Va générer et vérifier les jetons pour contrer la faille CSRF
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
        // On vérifie si le jeton CSRF est correct dans le form
        try{
            self::verifyToken(InputUtility::request_method());
        }
        catch (\Exception $e){}

        // On génère un jeton CSRF
        $token = self::generateToken(self::$csrf_token_name);

        // on l'assigne à un input dans le template
        self::$smarty = View::initView();

        self::$smarty->assign('csrf_token', $token);
    }


    private static function generateToken($input)
    {
        // Il faut indiquer le nom du champ input et session (identiques)
        if (empty($input)){
            return false;
        }

        $token = base64_encode(time() . sha1(InputUtility::ip()) . random_bytes(32));

        SessionUtility::getInstance()->setSession($input, $token);

        return $token;
    }

    /**
     * Vérifie si le token existe et s'il est bien dans le form
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
                View::error500("Le jeton CSRF est inexistant");
            }
        }
    }

    /**
     * Vérifie si le token donné dans un input correspond à celui en SESSION
     *
     * @param string $session_token le nom de la variable de session
     * @param string $token le valeur du input
     * @param float|int $timeout la durée max du token (3h par défaut)
     * @throws \Exception
     */
    private static function checkToken(string $session_token, string $token, $timeout = null)
    {
        if (!$token){
            View::error500("Le jeton CSRF est invalide");
        }

        $sessionToken = SessionUtility::getInstance()->getSession($session_token);

        if (!$sessionToken){
            View::error500("Jeton de session CSRF invalide");
        }

        if ($token !== $sessionToken){
            View::error500("Le jeton CSRF est différent du jeton de session");
        }

        // On vérifie aussi si le jeton a expiré
        if (is_int($timeout) && (intval(substr(base64_decode($sessionToken), 0, 10)) + $timeout) < time()){
            View::error500("Le jeton CSRF a expiré");
        }
    }
}
