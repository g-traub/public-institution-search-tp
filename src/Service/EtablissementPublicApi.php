<?php

namespace App\Service;

class EtablissementPublicApi
{
  public function getInfos($code)
  {
    $error = null;
    $infos = null;

    // request to api using curl
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://etablissements-publics.api.gouv.fr/v3/communes/$code/mairie");
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
    } elseif (count($arrResult['features']) === 0) {
      $error = 'Aucun informations pour la mairie de cette ville';
    } else {
      $infos = $arrResult['features'][0]['properties'];
    }
    return ['infos' => $infos, 'error' => $error];
  }
}
