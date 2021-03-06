<?php

namespace Config;

class DatabaseConfig
{
    /**
     * Le host de connexion à la bdd
     */
    const CONFIG_DATABASE_HOST = "";

    /**
     * Le port de connexion à la bdd
     */
    const CONFIG_DATABASE_PORT = "";

    /**
     * Le username de connexion à la bdd
     */
    const CONFIG_DATABASE_USER = "";

    /**
     * Le password de connexion à la bdd
     */
    const CONFIG_DATABASE_PASSWORD = "";

    /**
     * Le nom de la bdd
     */
    const CONFIG_DATABASE_DATABASE = "";

    /**
     * Si true, le mode transactionnel est activé
     */
    const CONFIG_DATABASE_TRANSACTIONS = "";

    /**
     * Retourne le host
     *
     * @return string
     */
    public static function getDatabaseHost(): string
    {
        return self::CONFIG_DATABASE_HOST;
    }

    /**
     * Retourne le port
     *
     * @return int
     */
    public static function getDatabasePort(): int
    {
        return self::CONFIG_DATABASE_PORT;
    }

    /**
     * Retourne le user
     *
     * @return string
     */
    public static function getDatabaseUser(): string
    {
        return self::CONFIG_DATABASE_USER;
    }

    /**
     * Retourne le password
     *
     * @return string
     */
    public static function getDatabasePassword(): string
    {
        return self::CONFIG_DATABASE_PASSWORD;
    }

    /**
     * Retourne le nom de la bdd
     *
     * @return string
     */
    public static function getDatabaseDbName(): string
    {
        return self::CONFIG_DATABASE_DATABASE;
    }

    /**
     * Retourne la valeur du mode transaction
     *
     * @return string
     */
    public static function getDatabaseTransactionMode(): string
    {
        return self::CONFIG_DATABASE_TRANSACTIONS;
    }

}
