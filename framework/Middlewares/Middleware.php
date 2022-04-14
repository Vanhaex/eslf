<?php

namespace Framework\Middlewares;

/**
 * Classe qui appelle un middleware s'il existe
 *
 */
class Middleware
{
    const MIDDLEWARE_NAMESPACE = "Framework\Middlewares\\";

    /**
     * Appelle le middleware demandé
     *
     * @param $middleware
     * @return bool
     */
    public static function process($middleware): bool
    {
        if (empty($middleware)) {
            return false;
        }

        // Au cas où par erreur on rajoute "Middleware" dans le nom de la classe.
        $middleware = preg_split("/(middleware)$/i", $middleware)[0];

        return self::searchClass($middleware);
    }

    /**
     * Cherche le middleware par son nom s'il existe
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

            // La méthode statique "execute" propre à tous les middlewares créés
            $MiddlewareClass::execute();
        }

        return false;
    }
}