<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Service\GeoApi;

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
  public function search()
  {
    $city = $request->query->get('city');
    $cp = $request->query->get('cp');
    $code = $geoApi->getCityCode($city, $cp);
    return $this->render('searchResults.html.twig');
  }
}
