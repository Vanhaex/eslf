<?php

namespace Framework;

use Config\AppConfig;

/**
 * Class for managing APIs
 *
 */
class ApiController
{
    private string $path;
    private string $method;

    public function __construct($path, $method)
    {
        $this->path = trim($path);
        $this->method = trim($method);
    }

    public function getAPI($param)
    {

        if (!in_array($this->method, ["GET", "POST"])){
            return $this->response("Incorrect HTTP method.", 500);
        }

        // If we just specify /api, it's not good, we inform the user
        if (preg_match("/^(\\" . AppConfig::getApiBaseUri() . ")(\/){0,1}$/im", $this->path)){
            return $this->response("The API name is missing.", 500);
        }

        // We will parse the URL first and then draw
        preg_match("/^(\\" . AppConfig::getApiBaseUri() . "|\\/{1})(\\/[a-zA-Z0-9]+|\\/{1})/im", $this->path, $matches);

        // If we don't have the basic URI that allows us to call the APIs
        if (count($matches) == 0 || $matches[1] !== AppConfig::getApiBaseUri()){
            return $this->response("Base URI seems to be incorrect. You should use this : '" . AppConfig::getApiBaseUri() . "'." , 500);
        }

        // We are therefore going to create the name of the API that we are going to look for
        $api_name = ucfirst(str_replace("/", "", $matches[2])) . "Api";

        // We check if there is
        $api_controller = "App\\api\\" . $api_name;

        if (class_exists($api_controller)) {

            $api_controller = new $api_controller();

            if (method_exists($api_controller, "index")) {

                $get = call_user_func_array(array($api_controller, "index"), $param);

            }
            else {
                return $this->response("Base method (index) seems to be inexistant.", 500);
            }
        }
        else {
            return $this->response("No API class named " . $api_name . " exists.", 500);
        }

        return $this->response($get);
    }

    /**
     * Return the API response in JSON format
     *
     * @param $message <p>Display the result</p>
     * @param int $code return http status code
     * @param string $content_type The MIME type that will be used to display response
     * @return false|string
     */
    private function response($message, int $code = 200, string $content_type = 'application/json'){
        header('Content-Type: ' . $content_type);
        http_response_code($code);

        $arrayResponse = [
            "code" => $code,
            "data" => $message
        ];

        return json_encode($arrayResponse);
    }

    /**
     * Will capture the url with parameters
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