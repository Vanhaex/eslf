<?php

namespace Framework;

use Config\AppConfig;

/**
 * Classe permettant de gérer les API
 *
 */
class ApiController
{
    private $path;
    private $method;

    public function __construct($path, $method)
    {
        $this->path = trim($path);
        $this->method = trim($method);
    }

    public function getAPI($param)
    {

        if (!in_array($this->method, ["GET", "POST"])){
            return $this->response("Méthode HTTP incorrecte.", 500);
        }

        // On va parser l'url dans un premier temps pour aller piocher ensuite
        preg_match("/^(\\" . AppConfig::getApiBaseUri() . "|\\/{1})(\\/[a-zA-Z0-9]+|\\/{1})/im", $this->path, $matches);

        // Si on a pas l'uri de base qui permet d'appeler les API
        if ($matches[1] !== AppConfig::getApiBaseUri()){
            return $this->response("L'URI de base pour les API semble incorrecte.", 500);
        }

        // On va donc créer le nom de l'api qu'on va chercher
        $api_name = ucfirst(str_replace("/", "", $matches[2])) . "Api";

        // On vérifie s'il existe bien
        $api_controller = "App\\api\\" . $api_name;

        if (class_exists($api_controller)) {

            $api_controller = new $api_controller();

            if (method_exists($api_controller, "index")) {

                $get = call_user_func_array(array($api_controller, "index"), $param);

            }
            else {
                return $this->response("La méthode de base (index) ne semble pas exister.", 500);
            }
        }
        else {
            return $this->response("Aucune classe API avec le nom " . $api_name . " n'existe.", 500);
        }

        return $this->response($get);
    }

    private function response($message, $code = 200, $content_type = 'application/json'){
        header('Content-Type: '.$content_type);
        http_response_code($code);

        $arrayResponse = [
            "code" => $code,
            "data" => $message
        ];

        return json_encode($arrayResponse);
    }

    /**
     * Permettra de capturer l'url avec les paramètres
     **/
    public function matchParameters($url)
    {
        $regexp_path = preg_replace('#:[a-z-_]+#', '([a-zA-Z0-9\-\_\/]+)', $this->path);

        $result = preg_match('#^' . $regexp_path . '$#', $url, $matches);
        array_splice($matches, 0, 1);
        if($result == 1){
            return $matches;
        }

        return false;
    }


}