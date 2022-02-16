<?php

namespace Framework\AlertMessage;

class Alert
{
    private $message;
    private $status;

    public function __construct($message, $status = "success")
    {
        $this->message = $message;
        $this->status = $status;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getStatus()
    {
        return $this->status;
    }
}
