<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        $movies = ["Avengers", "Loki", "Wall-e"];
        return $this->render('index.html.twig', array(
            'movies' => $movies
        ));
    }
        
}
