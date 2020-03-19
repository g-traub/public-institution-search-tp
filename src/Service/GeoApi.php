<?php

namespace App\Service;

class GeoApi
{
  public function getCityCode($name, $cp)
  {
    // @TODO: validation + trim

    // request to api using curl
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, "https://geo.api.gouv.fr/communes?codePostal=$cp&nom=$name&fields=code");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');


    $headers = array();
    $headers[] = 'Accept: application/json';
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $result = curl_exec($ch);
    if (curl_errno($ch)) {
      // @TODO : if api is offline, handle error
      echo 'Error:' . curl_error($ch);
    }
    curl_close($ch);
    // @TODO : test if results not empty
    return json_decode($result, true)[0]['code'];
  }
}
