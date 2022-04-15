<?php

namespace Config;

class AppConfig
{
    /**
     * Le type d'environnement du projet (dev, recette, prod)
     * Défaut : dev
     */
    const CONFIG_ENVIRONMENT= "dev";

    /**
     * La valeur du mode debug, permet d'afficher les erreurs PHP dans les vues
     * Défaut : true
     */
    const CONFIG_DEBUG = true;

    /**
     * Indique si on doit générer des logs. Pour ne pas instancier l'objet LogWriting et éviter les erreurs
     */
    const ACTIVATE_LOGS = true;

    /**
     * Le nom du dossier contenant les logs (ne doit pas finir par un "/")
     */
    const LOG_FILE_PATH = "log";

    /**
     * Indique si le projet nécessite la connexion à une base de données grâce à la lib ESDBaccess
     * Pour ne pas instancier d'objet mysqli et éviter les erreurs. Utile pour les pages statiques
     * Défaut : false
     */
    const ACTIVATE_DATABASE = false;


    /**
     * Retourne le type d'environnement du projet
     *
     * @return string
     */
    public static function getEnvironment(): string
    {
        return self::CONFIG_ENVIRONMENT;
    }

    /**
     * Retourne la valeur du mode debug
     *
     * @return string
     */
    public static function getDebug(): bool
    {
        return self::CONFIG_DEBUG;
    }

    /**
     * Retourne le dossier contenant les logs
     *
     * @return string
     */
    public static function getLogFilePath(): string
    {
        return self::LOG_FILE_PATH;
    }

    /**
     * Retourne
     *
     * @return string
     */
    public static function getActivateLogs(): string
    {
        return self::ACTIVATE_LOGS;
    }

    /**
     * Retourne la valeur qui indique si le projet utilise une connexion à une base de données
     *
     * @return bool
     */
    public static function getActivateDatabase(): bool
    {
        return self::ACTIVATE_DATABASE;
    }

}