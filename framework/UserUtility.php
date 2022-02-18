<?php

namespace Framework;


/**
 * Classe avec quelques méthodes utiles pour le contrôle de données utilisateurs
 */
class UserUtility
{
  /**
  * Méthode pour cacher une partie de l'email
  * @param string $email_address
  * @return $result
  **/
  public function HideEmail(string $email_address)
  {
    $em = $email_address;
    $stars = 4;
    $at = strpos($em,'@');
    if($at - 2 > $stars){
      $stars = $at - 2; // Ajouter +n étoiles en fonction de n caractères dans le préfixe si + de 4 étoiles
    }
    $result = substr($em,0,1) . str_repeat('*',$stars) . substr($em,$at - 1);

    return $result;
  }

  /**
  * Méthode pour vérifier la validité d'une adresse email
  * @param string $email_to_check
  *
  **/
  public function checkEmail(string $email_to_check)
  {
    if ($email_to_check == null || $email_to_check == "") {
      return false;
    }

    // La vilaine regex qui va vérifier l'adresse mail
    $regex = "/[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?/g";
    $test_email = ($regex, trim($email_to_check));

    if ($test_email == 1) {
      return true;
    }

    return false;
  }

  /**
  * Méthode pour vérifier la validité d'un numéro de téléphone. on peut préciser si c'est un fixe ou un portable
  * Par défaut on vérifie le num de portable
  * @param string $phone
  * @param bool $isCell
  *
  **/
  public function checkPhoneNumber(string $phone, bool $isCell = 1)
  {
    // Si on vérifie le numero de portable
    if ($isCell == 1) {
      $regex = "/^(06|07)(?!0+$)[0-9]{8}$/g";
    }
    elseif ($isCell == 0) {
      $regex = "/^[0-9]{10}$/g";
    }

    // Si on ajout $isCell en param, doit être obligatoirement un booléen
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
  * Méthode pour vérifier le type de la variable
  * @param string $value La variable pour laquelle on souhaite connaitre le type
  *
  **/
  public function checkTypeVariable($value)
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

    if (in_array($value, $vl)) {
      return true;
    }
    else {
      echo "N/A";
    }
  }
}


?>
