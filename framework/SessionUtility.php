<?php

namespace Framework;

/**
 * Class with static methods to handle session variables
 */
class SessionUtility
{
    // State of session variable
    const SESSION_ON = true;
    const SESSION_OFF = false;

    private static SessionUtility $instance;

    // Session closed by default
    private bool $sessionStatus = self::SESSION_OFF;

    private function __construct() {}

    /**
     * Signleton for one-time declaration
     *
     * @return SessionUtility
     */
    public static function getInstance(): SessionUtility
    {
        if (!isset(self::$instance)){
            self::$instance = new SessionUtility();
        }

        self::$instance->startSession();

        return self::$instance;
    }

    /**
     * Verify session variable then create it
     *
     * @return bool
     */
    public function startSession(): bool
    {
        if ($this->sessionStatus == self::SESSION_OFF)
        {
            session_start();
            $this->sessionStatus = self::SESSION_ON; // We precise state of session variable
        }

        return $this->sessionStatus;
    }

    /**
     * Verify session variable then destroy it
     *
     * @return bool
     */
    public function destroySession(): bool
    {
        if ($this->sessionStatus == self::SESSION_ON)
        {
            session_destroy();
            $this->sessionStatus = self::SESSION_OFF; // We precise state of session variable
        }

        return $this->sessionStatus;
    }

    /**
     * Verify state of variable
     *
     * @return bool
     */
    public function pingSession(): bool
    {
        $statut = session_status();

        if ($statut === PHP_SESSION_ACTIVE){
            return self::SESSION_ON;
        }

        return self::SESSION_OFF;
    }

    /**
     * Declare session variable and assign it some value
     *
     * @param $key
     * @param $value
     * @return void
     */
    public function setSession($key, $value)
    {
        $value = InputUtility::request("session", $value);

        $_SESSION[$key] = $value;
    }

    /**
     * Return value of session variable
     *
     * @param $key
     * @return false|mixed
     */
    public function getSession($key)
    {
        $key = InputUtility::request("session", $key);

        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }

        return false;
    }

    /**
     * Return all session variables
     *
     * @return mixed
     */
    public function getAllSession()
    {
        return $_SESSION;
    }

    /**
     * Verify if specifi session variable exists
     *
     * @param $key
     * @return bool
     */
    public function hasSession($key): bool
    {
        $key = InputUtility::request("session", $key);

        return isset($_SESSION[$key]);
    }

    /**
     * Destroy session variable
     *
     * @param $key
     * @return bool
     */
    public function unsetSession($key): bool
    {
        $key = InputUtility::request("session", $key);

        if (isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }

        return false;
    }

    /**
     * Destroy all session variables
     *
     * @return void
     */
    public function unsetAllSession()
    {
        session_unset();
    }
}

?>