<?php

namespace Framework;

class InputUtility
{
    /**
     * Known superglobal to handle request
     */
    const SUPERGLOBALS =
        [
            "GET",
            "POST",
            "SERVER",
            "SESSION",
            "COOKIE",
            "ENV",
            "FILES",
            "REQUEST"
        ];

    /**
     * Array of keys to reject and avoid SQL injection
     */
    const INJECTION_PROTECTION_KEY =
        [
            "insert", "select", "from",
            "where", "drop", "into",
            "open", "parameter", ";",
            "update", "close", "connect",
            "<script>", "database", "delete",
            "alter", "grant", "flush"
        ];

    const ACCEPTED_METHODS =
        [
            "GET",
            "POST"
        ];

    const FLAGS_FILES =
        [
            "FLAG_NONE" => "",
            "FLAG_NAME" => "name",
            "FLAG_TYPE" => "type",
            "FLAG_TMP_NAME" => "tmp_name",
            "FLAG_ERROR" => "error",
            "FLAG_SIZE" => "size",
        ];

    /**
     * Prevent from SQL injections and XSS
     *
     * @param array $array
     * @param string $values
     * @param $defaultValue
     * @return array|string
     */
    private static function preventInjectionArray(array $array, string $values, $defaultValue)
    {
        if ($values === null){
            return $array;
        }

        if (isset($array[$values])){
            $value = str_replace(InputUtility::INJECTION_PROTECTION_KEY, '', $array[$values]);
            return htmlspecialchars($value, ENT_QUOTES);
        }
        else {
            return $defaultValue;
        }
    }

    /**
     * Prevent from SQL injections and XSS for FILES method
     *
     * @param array $array
     * @param string $values
     * @param string $type
     * @param string $defaultValue
     * @return array|string
     */
    private static function preventInjectionArrayFiles(array $array, string $values, string $type, string $defaultValue)
    {
        if ($values === null){
            return $array;
        }

        if (isset($array[$values])){
            $type = str_replace(InputUtility::INJECTION_PROTECTION_KEY, '', $type);
            return $array[$values][$type];
        }
        else {
            return $defaultValue;
        }
    }

    public static function request(string $superglobal, $value, $default = null, $files_opt = "")
    {
        $superglobal = trim($superglobal);

        if (!in_array(strtoupper($superglobal), self::SUPERGLOBALS)){
            return false;
        }

        // If we use FILES method, we call the specific function to get files data
        if (strtoupper($superglobal) === "FILES"){
            return self::fileRequest($value, $default, $files_opt);
        }

        // Overriden methods will be converted in POST method automatically
        if (strtoupper($superglobal) == "PUT" || strtoupper($superglobal) == "DELETE" || isset($_POST["HTTP_X_HTTP_METHOD_OVERRIDE"]) || isset($_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"])){
            $superglobal = "POST";
        }

        $request = self::prepareMethod($superglobal);

        return self::preventInjectionArray($request, $value, $default);
    }

    private static function fileRequest($value, $options, $default = null)
    {
        $request = self::prepareMethod("_FILES");

        $type = self::FLAGS_FILES[$options];

        return self::preventInjectionArrayFiles($request, $value, $type, $default);
    }

    public static function prepareMethod(string $superglobal): array
    {
        $superglobal = preg_replace("/[\d\s]+/m", "", $superglobal);

        $superglobal = '_' . strtoupper($superglobal);

        global ${$superglobal}; // We should consider that string "_GET", "_POST" or other is a global variable

        return ${$superglobal};
    }

    /**
     * Return client IP address.
     * If we can't get it, default IP will be 0.0.0.0
     **/
    public static function ip()
    {
        if (self::request('server','HTTP_CLIENT_IP') !== null) {
            $ips[] = self::request('server','HTTP_CLIENT_IP');
            // Filtering client IP
            foreach ($ips as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 || FILTER_FLAG_IPV6 || FILTER_FLAG_NO_PRIV_RANGE || FILTER_FLAG_NO_RES_RANGE)) {
                    return $ip;
                }
            }
        }

        return self::request('server','REMOTE_ADDR', '0.0.0.0');
    }

    /**
     * Method for cleaning URI
     **/
    public static function clean_uri()
    {
        $path = trim(strtok(self::request("server", "REQUEST_URI"),'?'));

        if(substr($path, -1) == '/' && strlen($path) > 1) {
            $path = substr($path, 0, -1);
        }

        if(strncmp($path, '/index.php', 10) == 0){
            $path = '/';
        }

        return $path;
    }

    /**
     * Return query method used (GET, POST, ...)
     * Verify overriden methods
     *
     **/
    public static function request_method()
    {
        if (self::http_x_http_method_override()){
            return self::request("post", "HTTP_X_HTTP_METHOD_OVERRIDE") || self::request("server", "HTTP_X_HTTP_METHOD_OVERRIDE");
        }

        $req_method = self::request("server", "REQUEST_METHOD");

        return strtoupper($req_method);
    }

    /**
     * Verify if it's overriden method
     * @return bool
     */
    private static function http_x_http_method_override(): bool
    {
        return isset($_POST["HTTP_X_HTTP_METHOD_OVERRIDE"]) || isset($_SERVER["HTTP_X_HTTP_METHOD_OVERRIDE"]);
    }
}