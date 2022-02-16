<?php

namespace Framework;

class SessionUtility
{
    // Le statut de la session, si elle est ouverte ou non
    const SESSION_ON = true;
    const SESSION_OFF = false;

    private static $instance;

    // La session est fermée par défaut
    private $sessionStatus = self::SESSION_OFF;

    private function __construct() {}

    /**
     * Un singleton qui va nous permettre d'instancier qu'une seule fois
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
     * Créé une session après avoir vérifié son statut
     *
     * @return bool
     */
    public function startSession(): bool
    {
        if ($this->sessionStatus == self::SESSION_OFF)
        {
            session_start();
            $this->sessionStatus = self::SESSION_ON; // On précise bien le statut de la session
        }

        return $this->sessionStatus;
    }

    /**
     * Détruit une session après avoir vérifié son statut
     *
     * @return bool
     */
    public function destroySession(): bool
    {
        if ($this->sessionStatus == self::SESSION_ON)
        {
            session_destroy();
            $this->sessionStatus = self::SESSION_OFF; // On précise bien le statut de la session
        }

        return $this->sessionStatus;
    }

    /**
     * Vérifie l'état de la session
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
     * Déclare une variable de session et lui assigne une valeur
     *
     * @param $key
     * @param $value
     * @return void
     */
    public function setSession($key, $value)
    {
        $value = InputUtility::session($value);

        $_SESSION[$key] = $value;
    }

    /**
     * Retourne la valeur d'une variable de session
     *
     * @param $key
     * @return false|mixed
     */
    public function getSession($key)
    {
        $key = InputUtility::session($key);

        if (isset($_SESSION[$key])){
            return $_SESSION[$key];
        }

        return false;
    }

    /**
     * Retourne toutes les variables de session existantes
     *
     * @return array
     */
    public function getAllSession(): array
    {
        return $_SESSION;
    }

    /**
     * Vérifie si une variable de session en particulier existe
     *
     * @param $key
     * @return bool
     */
    public function hasSession($key): bool
    {
        $key = InputUtility::session($key);

        return isset($_SESSION[$key]);
    }

    /**
     * Détruit une variable de session
     *
     * @param $key
     * @return bool
     */
    public function unsetSession($key): bool
    {
        $key = InputUtility::session($key);

        if (isset($_SESSION[$key])){
            unset($_SESSION[$key]);
        }

        return false;
    }

    /**
     * Détruit toutes les variables de session
     *
     * @return void
     */
    public function unsetAllSession()
    {
        session_unset();
    }
}

?>
