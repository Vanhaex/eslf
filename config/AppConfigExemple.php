<?php

namespace Config;

class AppConfigExemple
{
    /**
     * Le type d'environnement du projet (dev, recette, prod)
     */
    const CONFIG_ENVIRONMENT_EXEMPLE= "dev";

    /**
     * La valeur du mode debug, permet d'afficher les erreurs PHP dans les vues
     */
    const CONFIG_DEBUG_EXEMPLE = "true";

    /**
     * Le chemin vers le dossier contenant les logs
     */
    const LOG_FILE_PATH_EXEMPLE = "/chemin/vers/le/dossier/log/";


    /**
     * Retourne le type d'environnement du projet
     *
     * @return string
     */
    public static function getEnvironment(): string
    {
        return self::CONFIG_ENVIRONMENT_EXEMPLE;
    }

    /**
     * Retourne la valeur du mode debug
     *
     * @return string
     */
    public static function getDebug(): string
    {
        return self::CONFIG_DEBUG_EXEMPLE;
    }

    /**
     * Retourne le chemin des logs
     *
     * @return string
     */
    public static function getLogFilePath(): string
    {
        return self::LOG_FILE_PATH_EXEMPLE;
    }

}