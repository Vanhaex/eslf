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
            self::verifyToken(InputUtility::request_method(), 'csrf_token');
        }
        catch (\Exception $e){}

        // On génère un jeton CSRF
        $token = self::generateToken('csrf_token');

        // on l'assigne à un input dans le template
        $smarty = View::initView();

        $smarty->assign('csrf_token', $token);
    }

    /**
     *  Génère une jeton CSRF
     *
     * @param $input
     * @return bool
     * @throws \Exception
     */
    private static function generateToken($input)
    {
        // Il faut indiquer le nom du champ input et session (identiques)
        if (empty($input)){
            return false;
        }


        $token = base64_encode(
                time() .
                sha1(InputUtility::server('REMOTE_ADDR')) .
                sha1(random_bytes(32)));

        SessionUtility::getInstance()->setSession($input, $token);

        return $token;
    }

    /**
     * Vérifie si le token existe et s'il est bien dans le form
     *
     * @param $method
     * @param $input
     * @throws \Exception
     */
    private static function verifyToken($method, $input)
    {
        if ($method === "POST"){
            if (InputUtility::post($input)){
                self::checkToken($input, InputUtility::post($input));
            }
            else{
                throw new \Exception("Le jeton CSRF est inexistant");
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
    private static function checkToken($session_token, $token, $timeout = 3*60*60)
    {
        if (!$token){
            throw new \Exception("Le jeton CSRF est invalide");
        }

        $sessionToken = SessionUtility::getInstance()->getSession($session_token);

        if (!$sessionToken){
            throw new \Exception("Jeton de session CSRF invalide");
        }

        if ($token !== $sessionToken){
            throw new \Exception("Le jeton CSRF est invalide");
        }

        // On vérifie aussi si le jeton a expiré
        if (is_int($timeout) && (intval(substr(base64_decode($sessionToken), 0, 0)) + $timeout) < time()){
            throw new \Exception("Le jeton CSRF a expiré");
        }
    }
}
