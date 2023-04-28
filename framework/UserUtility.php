<?php

namespace Framework;

use UAParser\Exception\FileNotFoundException;
use UAParser\Parser;

/**
 * Class with some useful methods to handle user informations
 */
class UserUtility
{

    /**
     * Evil regex for email control
     */
    const EMAIL_REGEX = '/^(?!(?>(?1)"?(?>\\\[ -~]|[^"])"?(?1)){255,})(?!(?>(?1)"?(?>\\\[ -~]|[^"])"?(?1)){65,}@)((?>(?>(?>((?>(?>(?>\x0D\x0A)?[\t ])+|(?>[\t ]*\x0D\x0A)?[\t ]+)?)(\((?>(?2)(?>[\x01-\x08\x0B\x0C\x0E-\'*-\[\]-\x7F]|\\\[\x00-\x7F]|(?3)))*(?2)\)))+(?2))|(?2))?)([!#-\'*+\/-9=?^-~-]+|"(?>(?2)(?>[\x01-\x08\x0B\x0C\x0E-!#-\[\]-\x7F]|\\\[\x00-\x7F]))*(?2)")(?>(?1)\.(?1)(?4))*(?1)@(?!(?1)[a-z0-9-]{64,})(?1)(?>([a-z0-9](?>[a-z0-9-]*[a-z0-9])?)(?>(?1)\.(?!(?1)[a-z0-9-]{64,})(?1)(?5)){0,126}|\[(?:(?>IPv6:(?>([a-f0-9]{1,4})(?>:(?6)){7}|(?!(?:.*[a-f0-9][:\]]){8,})((?6)(?>:(?6)){0,6})?::(?7)?))|(?>(?>IPv6:(?>(?6)(?>:(?6)){5}:|(?!(?:.*[a-f0-9]:){6,})(?8)?::(?>((?6)(?>:(?6)){0,4}):)?))?(25[0-5]|2[0-4][0-9]|1[0-9]{2}|[1-9]?[0-9])(?>\.(?9)){3}))\])(?1)$/sD';

    /**
     * Method for hiding email adress
     * @param string $email_address
     * @return string $result
     */
    public static function HideEmail(string $email_address): string
    {
        $em = $email_address;
        $stars = 4;
        $at = strpos($em,'@');
        if($at - 2 > $stars){
            $stars = $at - 2; // Add +n stars based on n characters in the prefix if + 4 stars
        }

        return substr($em,0,1) . str_repeat('*',$stars) . substr($em,$at - 1);
    }

    /**
     * Method for verifying email adress validity
     * @param string $email_to_check
     *
     * @return bool
     */
    public static function checkEmail(string $email_to_check): bool
    {
        if ($email_to_check == null || $email_to_check == "") {
            return false;
        }

        $adresses = preg_split('/[,;]/', $email_to_check);

        foreach ($adresses as $adress){
            $test_email = preg_match(self::EMAIL_REGEX, trim($adress));

            if ($test_email == 1) {
                return true;
            }
        }

        return false;
    }

    /**
     * Method for verifying phone number validity. We can precise if it's cell number or not
     * @param string $phone
     * @param int $isCell
     *
     * @return bool
     */
    public static function checkPhoneNumber(string $phone, int $isCell = 1): bool
    {
        if ($isCell == 1) {
            $regex = "/^(06|07)(?!0+$)\d{8}$/";
        }
        elseif ($isCell == 0) {
            $regex = "/^\d{10}$/";
        }
        else {
            return false;
        }

        // Must be boolean
        if (!is_bool($isCell)) {
            return false;
        }

        $test_phone = preg_match($regex, trim($phone));

        if ($test_phone == 1) {
            return true;
        }

        return false;
    }

    /**
     * Method for verifying variable type
     * @param string $value The variable for which we want to know the type
     */
    public static function checkTypeVariable(string $value)
    {
        if (!isset($value)) {
            return false;
        }

        $types = [
            "string",
            "integer",
            "double",
            "boolean",
            "array",
            "object",
            "NULL",
        ];

        $vl = gettype($value);

        if (in_array($vl, $types)) {
            return true;
        }

        return "null";
    }

    /**
     * Return browser name
     *
     * @param bool $version If true, return also the version
     * @return string
     * @throws FileNotFoundException
     */
    public static function getBrowser(bool $version = false): string
    {
        $ua = InputUtility::request("server", "HTTP_USER_AGENT");

        $parser = Parser::create();
        $result = $parser->parse($ua);

        $browser = $result->ua->family;

        if ($version){
            $browser = $result->ua->toString();
        }

        return $browser;
    }

    /**
     * Return operating system name
     *
     * @param bool $version If true, return also the version
     * @return string
     * @throws FileNotFoundException
     */
    public static function getOS(bool $version = false): string
    {
        $ua = InputUtility::request("server", "HTTP_USER_AGENT");

        $parser = Parser::create();
        $result = $parser->parse($ua);

        $os = $result->os->family;

        if ($version){
            $os = $result->os->toString();
        }

        return $os;
    }
}

?>