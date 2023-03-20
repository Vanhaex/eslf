<?php

namespace Framework\Model;

use Config\DatabaseConfig;
use ESDBaccess\ESDBaccess;
use ESDBaccess\ESDBaccessException;

abstract class Model
{
    protected $table;
    protected $columns = [];

    /**
     * @var ESDBaccess
     */
    private ESDBaccess $esdbaccess;

    /**
     * @throws ESDBaccessException
     */
    public function __construct()
    {
        // On initialise la connexion
        self::getMysqlConnection();

    }

    /**
     * Récupère toutes les lignes de la table
     *
     * @return array|null
     * @throws ESDBaccessException
     */
    public function getAll($orderBy = "", $order = "ASC")
    {
        $this->esdbaccess->querySelect(
            $this->getTable(),
            $this->getColumns(),
            (!empty($orderBy)
                ? !empty($order)
                    ? "ORDER BY " . $this->sanitizeString($orderBy) . " " . $this->sanitizeString($order)
                    : ""
                : ""
            )
        );

        return $this->esdbaccess->allResults();
    }

    /**
     * Retourne quelques lignes de la table
     *
     * @param int $limit
     * @param $orderBy
     * @param $order
     * @return array|false|null
     * @throws ESDBaccessException
     */
    public function getSome(int $limit, $orderBy = "", $order = "ASC")
    {
        if (empty($limit)){
            return false;
        }

        var_dump($this->sanitizeInt($limit));

        $this->esdbaccess->querySelect(
            $this->getTable(),
            $this->getColumns(),
            (!empty($orderBy)
                ? !empty($order)
                    ? "ORDER BY " . $this->sanitizeString($orderBy) . " " . $this->sanitizeString($order)
                    : ""
                : ""
            )
            . " LIMIT " . $this->sanitizeInt($limit)
        );

        return $this->esdbaccess->allResults();
    }

    /**
     * Retourne la table définie dans le model
     *
     * @return mixed
     */
    private function getTable()
    {
        return trim($this->table);
    }

    /**
     * Retourne les colonnes définies dans le modèle
     *
     * @return array
     */
    private function getColumns()
    {
        return $this->columns;
    }

    private function sanitizeString(string $string)
    {
        if (gettype($string) !== "string"){
            return false;
        }

        return $string;
    }

    private function sanitizeInt(int $int)
    {
        if (gettype($int) !== "integer"){
            return false;
        }

        return $int;
    }

    /**
     * Initialise la connexion à la base de données
     *
     * @return void
     * @throws ESDBaccessException
     */
    private function getMysqlConnection(): void
    {
        if (!isset($this->esdbaccess)){
            $this->esdbaccess = new ESDBaccess(DatabaseConfig::getDatabaseHost(), DatabaseConfig::getDatabaseUser(), DatabaseConfig::getDatabasePassword(), DatabaseConfig::getDatabaseDbName(), DatabaseConfig::getDatabasePort());
            $this->esdbaccess->connectToDB();
            $this->esdbaccess->ESDBautocommit(DatabaseConfig::getDatabaseTransactionMode());
        }

    }
}