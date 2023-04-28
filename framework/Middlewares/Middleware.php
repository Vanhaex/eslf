<?php

namespace Framework\Middlewares;

/**
 * Class that call Middleware
 *
 */
class Middleware
{
    const MIDDLEWARE_NAMESPACE = "Framework\Middlewares\\";

    /**
     * Call desired middleware
     *
     * @param $middleware
     * @return bool
     */
    public static function process($middleware): bool
    {
        if (empty($middleware)) {
            return false;
        }

        // If we add "Middleware" in case of error.
        $middleware = preg_split("/(middleware)$/i", $middleware)[0];

        return self::searchClass($middleware);
    }

    /**
     * Search middleware by his name if it exists
     *
     * @param $class
     * @return bool
     */
    private static function searchClass($class): bool
    {

        if (empty($class)){
            return false;
        }

        if (class_exists(self::MIDDLEWARE_NAMESPACE . $class . "Middleware")){

            $MiddlewareClass = self::MIDDLEWARE_NAMESPACE . $class . "Middleware";

            // Static methode for all middlewares that execute them
            call_user_func($MiddlewareClass . "::execute");
        }

        return false;
    }
}