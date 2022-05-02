<?php

namespace Framework\AlertMessage;

class Alert
{
    private string $message;
    private string $status;

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
