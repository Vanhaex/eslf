<?php

namespace Config;

class AppConfig
{
    /**
     * Project's environment (dev, prod, ...)
     * Default : dev
     */
    const CONFIG_ENVIRONMENT= "dev";

    /**
     * Debug mode, determine if we show PHP notice or errors messages in templates
     * Default : true
     */
    const CONFIG_DEBUG = true;

    /**
     * For using logs
     */
    const ACTIVATE_LOGS = false;

    /**
     * Folder's name for logs (must not finish by '/')
     */
    const LOG_FILE_PATH = "log";

    /**
     * Tell if we want to use ESDBaccess for retrieve and use database.
     * If false, it will not be instanciated
     * Default : false
     */
    const ACTIVATE_DATABASE = false;

    /**
     * Base URI for API use. Must not contain exotic characters
     * Default : '/api'
     */
    const API_BASE_URI = "/api";


    /**
     * Return project environment value
     *
     * @return string
     */
    public static function getEnvironment(): string
    {
        return self::CONFIG_ENVIRONMENT;
    }

    /**
     * Return debug mode value
     *
     * @return bool
     */
    public static function getDebug(): bool
    {
        return self::CONFIG_DEBUG;
    }

    /**
     * Return logs folder value
     *
     * @return string
     */
    public static function getLogFilePath(): string
    {
        return self::LOG_FILE_PATH;
    }

    /**
     * Return logs activation value
     *
     * @return bool
     */
    public static function getActivateLogs(): bool
    {
        return self::ACTIVATE_LOGS;
    }

    /**
     * Return database use value
     *
     * @return bool
     */
    public static function getActivateDatabase(): bool
    {
        return self::ACTIVATE_DATABASE;
    }

    /**
     * Return base URI for API use value
     *
     * @return string
     */
    public static function getApiBaseUri(): string
    {
        return self::API_BASE_URI;
    }
}