<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Fichier :  function.alert_message.php
 * Type :     fonction
 * Nom :      flash_message
 * Rôle :     Affiche un message d'alerte (ou message flash) dans un template
 * -------------------------------------------------------------
 */
function smarty_function_alert_message()
{
    require_once("../framework/AlertMessage/AlertMessage.php");

    $AlertMessage = new Framework\AlertMessage\AlertMessage();

    $alerts = $AlertMessage->getAlertMessage();

    if (is_null($alerts)){
        $alerts = [];
    }

    $string = "<div></div>";

    // TODO : écrire les tag html
}


?>
