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

    $string .= "<div class='alert-message' >";
    $string .= "<strong>Erreur : </strong>";
    $string .= "<p>Un simple message d'erreur</p>";

    $string .= "</div>";

    return $string;
}


?>