<?php

namespace Framework;

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
            self::$smarty->setPluginsDir($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'smarty_plugins' . DIRECTORY_SEPARATOR);
            if (CONFIG_DEBUG == "true") {
                self::$smarty->cache_lifetime = 0;
                self::$smarty->setCaching(Smarty::CACHING_OFF);
            }
        }

        return self::$smarty;
    }
}