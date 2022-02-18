<?php

namespace Framework\Middlewares;

class VerifyCSRFMiddleware
{
    /**
     * Lance ce qui va être executé par le Middleware
     *
     * @return void
     */
    public static function execute()
    {
        /*
         *
         *     // Authentification par jeton CSRF
                $sessionProvider = new EasyCSRF\NativeSessionProvider();
                $easyCSRF = new EasyCSRF\EasyCSRF($sessionProvider);

                // On vérifie si le jeton CSRF est correct dans le form
                try{
                    if(RequestUtility::method() === "POST"){
                        if(RequestUtility::has('csrf_token')) {
                            $easyCSRF->check('csrf_token', $_POST['csrf_token'], 3*60*60);
                        }
                        else{
                            throw new \Exception("Le jeton CSRF est inexistant");
                        }
                    }
                }catch (\APICEM\APICRYPT\Exceptions\CRSFException $e){}

                // On génère un jeton CSRF puis on l'assigne à un input dans le template
                $token = $easyCSRF->generate('csrf_token');

                $smarty->assign('csrf_token', $token);

         *
         * */
    }


}