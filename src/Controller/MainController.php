<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\GeoApi;
use App\Service\EtablissementPublicApi;

class MainController extends AbstractController
{
  /**
   * @Route("/", name="homepage")
   */
  public function index()
  {
    return $this->render('homepage.html.twig');
  }

  /**
   * @Route("/search", name="search_results")
   */
  public function search(Request $request, GeoApi $geoApi, EtablissementPublicApi $etablissementPublicApi)
  {
    $city = trim($request->query->get('city'));
    $cp = trim($request->query->get('cp'));

    // validation
    if (!preg_match('/^[a-zA-Z]+([- ]?[a-zA-Z]*)+$/m', $city) || !preg_match('/^(([0-8][0-9])|(9[0-5]))[0-9]{3}$/m', $cp)) {
      return $this->render('error.html.twig', ['error' => 'Le nom de la ville et/ou le code postal sont incorrects']);
    }

    // what to render
    $resultCode = $geoApi->getCityCode($city, $cp);
    if (isset($resultCode['code'])) {
      $resultInfos = $etablissementPublicApi->getInfos($resultCode['code']);
      if (isset($resultInfos['infos'])) {
        return $this->render('searchResults.html.twig', $resultInfos['infos']);
      } else {
        return $this->render('error.html.twig', ['error' => $resultInfos['error']]);
      }
    } else {
      return $this->render('error.html.twig', ['error' => $resultCode['error']]);
    }
  }
}
