<?php

namespace Framework\AlertMessage;

use Framework\SessionUtility;

class AlertMessage
{
    private $session;

    private function sessionAlertMessage()
    {
        $this->session = SessionUtility::getInstance();
    }

    /**
     * Créé un message d'alerte en tant de variable de session
     *
     * @param $message
     * @param $status
     * @return void
     */
    public function addAlertMessage($message, $status = "success")
    {
        if ($this->session->hasSession("alert_messages"))
        {
            // Pour l'instant c'est un array vide et on va ajouter le message et le statut ensuite
            $this->session->setSession("alert_messages", []);
        }

        $messages_array = $this->session->getSession("alert_messages");

        $add_message = new Alert($message, $status);
        $messages_array[] = $add_message;

        $this->session->setSession("alert_messages", $messages_array);
    }

    /**
     * Retourne les messages d'alertes
     *
     * @return array|false|mixed
     */
    public function getAlertMessage()
    {
        $messages_array = $this->session->getSession("alert_messages");

        // Si il n'y a aucun message, on redéclare la liste des messages par un tableau vide
        if(!$messages_array){
            $messages_array = [];
        }

        $this->session->setSession("alert_messages", []);

        return $messages_array;
    }

    /**
     * Vérifie s'il existe des messages d'alerte
     *
     * @return bool
     */
    public function hasAlertMessages(): bool
    {
        return $this->session->hasSession("alert_messages") && count($this->session->getSession("alert_messages")) > 0;
    }
}
