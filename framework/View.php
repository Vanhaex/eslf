<?php

namespace Framework;

use Config\AppConfig;
use Framework\LogWriting;
use Smarty;

class View
{
    private static $smarty;

    /**
     * Classe pour gérer le moteur de templating Smarty
     * @package Framework
     */
    public static function initView()
    {
        if (is_null(self::$smarty)) {
            self::$smarty = new Smarty();

            // Configuration de Smarty
            self::$smarty->setTemplateDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'views' .  DIRECTORY_SEPARATOR);
            self::$smarty->setCompileDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'views_c' . DIRECTORY_SEPARATOR);
            self::$smarty->setCacheDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .  'cache' . DIRECTORY_SEPARATOR);
            self::$smarty->setPluginsDir(array(
                                            SMARTY_PLUGINS_DIR,
                                            $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'smarty_plugins' . DIRECTORY_SEPARATOR));
            if (AppConfig::getDebug() == "true") {
                self::$smarty->caching = false;
                self::$smarty->cache_lifetime = 0;
                self::$smarty->setCaching(Smarty::CACHING_OFF);
            }
            else {
                self::$smarty->debugging = false;
                self::$smarty->caching = true;
                self::$smarty->cache_lifetime = 3600;
            }
        }

        return self::$smarty;
    }

    /**
     * Retourne le template en cas d'erreur 404
     * 
     * @return void
     */
    public static function error404()
    {
        header("HTTP/1.1 404 Not Found");
        $log = new LogWriting();
        $log->write("testlog.log", "WARNING", "HTTP/1.1 404 Not Found");
        self::$smarty->display($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "errors" . DIRECTORY_SEPARATOR . "404.tpl");
        exit(); // On arrête l'exécution du script au cas où
    }

    /**
     * Retourne le template en cas d'erreur 500
     *
     * @return void
     */
    public static function error500($message)
    {
        header("HTTP/1.1 500 Internal Server Error");

        // Affichage du message si erreur 500
        if (AppConfig::getDebug() == "true") {
            self::$smarty->assign('detail_exception', 'Détails de l\'erreur : ' . $message);
        }
        $log = new LogWriting();
        $log->write("testlog.log", "ERROR", "HTTP/1.1 500 Internal Server Error. " . $message);
        self::$smarty->display($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "errors" . DIRECTORY_SEPARATOR . "500.tpl");
        exit(); // On arrête l'exécution du script au cas où
    }
}