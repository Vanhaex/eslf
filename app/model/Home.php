<?php

namespace App\model;

use Framework\Model\Model;

class Home extends Model
{
    /**
     * La table en base de données qui sera utilisée par le Model
     *
     * @var string
     */
    protected $table = "test_table";

    /**
     * Les colonnes de la table qui seront utilisée par la Model
     *
     * @var array
     */
    protected $columns =
        [
            "id",
            "name"
        ];
}