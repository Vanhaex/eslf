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
   * @return string $result
   */
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
   * @return bool
   */
  public function checkEmail(string $email_to_check)
  {
    if ($email_to_check == null || $email_to_check == "") {
      return false;
    }

    // La vilaine regex qui va vérifier l'adresse mail
    $regex = "/[a-z\d!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z\d!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z\d](?:[a-z\d-]*[a-z\d])?\.)+[a-z\d](?:[a-z\d-]*[a-z\d])?/";
    $test_email = preg_match($regex, trim($email_to_check));

    if ($test_email == 1) {
      return true;
    }

    return false;
  }

  /**
   * Méthode pour vérifier la validité d'un numéro de téléphone. on peut préciser si c'est un fixe ou un portable
   * Par défaut on vérifie le num de portable
   * @param string $phone
   * @param int $isCell
   *
   * @return bool
   */
  public function checkPhoneNumber(string $phone, int $isCell = 1)
  {
    // Si on vérifie le numero de portable
    if ($isCell == 1) {
      $regex = "/^(06|07)(?!0+$)\d{8}$/";
    }
    elseif ($isCell == 0) {
      $regex = "/^\d{10}$/";
    }
    else {
      return false;
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
   *
   * @return bool
   */
  public function checkTypeVariable(string $value)
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

    return "N/A";
  }
}


?>
