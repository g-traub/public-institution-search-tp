<?php

namespace App\Service;

class GeoApi
{
  public function getCityCode($name, $cp)
  {
    $error = null;
    $code = null;

    // request to api using curl
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://geo.api.gouv.fr/communes?codePostal=$cp&nom=$name&fields=code");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    curl_close($ch);

    $arrResult = json_decode($result, true);

    if ($arrResult === null) {
      $error = 'Une erreur est survenue, veuillez réessayer ultérieurement';
    } elseif (count($arrResult) === 0) {
      $error = 'Aucun résultat pour cette recherche';
    } else {
      $code = $arrResult[0]['code'];
    }
    return ['code' => $code, 'error' => $error];
  }
}
