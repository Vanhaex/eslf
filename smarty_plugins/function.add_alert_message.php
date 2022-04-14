<?php

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Fichier :  function.add_alert_message.php
 * Type :     fonction
 * Nom :      add_alert_message
 * Rôle :     Affiche un message d'alerte (ou message flash) dans un template
 * -------------------------------------------------------------
 */
function smarty_function_add_alert_message()
{
    require_once("../framework/AlertMessage/AlertMessage.php");

    $AlertMessage = new Framework\AlertMessage\AlertMessage();

    $alerts = $AlertMessage->getAlertMessage();

    if (is_null($alerts)){
        $alerts = [];
    }

    $string = "<div>";

    foreach ($alerts as $alert){
        $string .= "<div class='alert-message-{$alert->getStatus()}' >";
            $string .= "<p>{$alert->getMessage()}</p>";
        $string .= "</div>";
    }

    $string .= "</div>";

    return $string;
}


?>