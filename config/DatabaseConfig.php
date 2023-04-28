<?php

namespace Config;

class DatabaseConfig
{
    /**
     * Host for DDB connexion
     */
    const CONFIG_DATABASE_HOST = "localhost";

    /**
     * Port for DDB connexion
     */
    const CONFIG_DATABASE_PORT = 3306;

    /**
     * Username for DDB connexion
     */
    const CONFIG_DATABASE_USER = "";

    /**
     * Password for DDB connexion
     */
    const CONFIG_DATABASE_PASSWORD = "";

    /**
     * Database name for DDB connexion
     */
    const CONFIG_DATABASE_DATABASE = "";

    /**
     * If true, transaction will be activated
     */
    const CONFIG_DATABASE_TRANSACTIONS = true;

    /**
     * Return host
     *
     * @return string
     */
    public static function getDatabaseHost(): string
    {
        return self::CONFIG_DATABASE_HOST;
    }

    /**
     * Return port
     *
     * @return int
     */
    public static function getDatabasePort(): int
    {
        return self::CONFIG_DATABASE_PORT;
    }

    /**
     * Return username
     *
     * @return string
     */
    public static function getDatabaseUser(): string
    {
        return self::CONFIG_DATABASE_USER;
    }

    /**
     * Return password
     *
     * @return string
     */
    public static function getDatabasePassword(): string
    {
        return self::CONFIG_DATABASE_PASSWORD;
    }

    /**
     * Return database name
     *
     * @return string
     */
    public static function getDatabaseDbName(): string
    {
        return self::CONFIG_DATABASE_DATABASE;
    }

    /**
     * Return transaction mode value
     *
     * @return bool
     */
    public static function getDatabaseTransactionMode(): bool
    {
        return self::CONFIG_DATABASE_TRANSACTIONS;
    }
}
