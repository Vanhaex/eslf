<?php

namespace Framework\AlertMessage;

use Framework\SessionUtility;

class AlertMessage
{
    private SessionUtility $session;

    public function __construct()
    {
        $this->session = SessionUtility::getInstance();
    }

    /**
     * Create alert message as session variable
     *
     * @param $message
     * @param string $status
     * @return void
     */
    public function addAlertMessage($message, string $status = "success")
    {
        if ($this->session->hasSession("alert_messages"))
        {
            // For the moment, we create empty array and adding message and status later
            $this->session->setSession("alert_messages", []);
        }

        $messages_array = $this->session->getSession("alert_messages");

        $add_message = new Alert($message, $status);
        $messages_array[] = $add_message;

        $this->session->setSession("alert_messages", $messages_array);
    }

    /**
     * Return alert messages
     *
     * @return array|false|mixed
     */
    public function getAlertMessage()
    {
        $messages_array = $this->session->getSession("alert_messages");

        // If there's no messages, we declare messages list with empty array
        if(!$messages_array){
            $messages_array = [];
        }

        $this->session->setSession("alert_messages", []);

        return $messages_array;
    }

    /**
     * Verify if there's alert messages
     *
     * @return bool
     */
    public function hasAlertMessages(): bool
    {
        return $this->session->hasSession("alert_messages") && count($this->session->getSession("alert_messages")) > 0;
    }
}
