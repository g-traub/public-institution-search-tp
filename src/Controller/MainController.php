<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
  /**
   * @Route("/", name="homepage")
   */
  public function index()
  {
    return $this->render('homepage.html.twig');
  }
}
