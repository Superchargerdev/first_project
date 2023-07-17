<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class FirstController extends AbstractController
{
    // private $em;
    // private $movieRepository;
    // public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository) 
    // {
    //     $this->em = $em;
    //     $this->movieRepository = $movieRepository;
    // }

    private $movieRepository;
    public function __construct(MovieRepository $movieRepository)
    {
        $this->movieRepository = $movieRepository;
    }

    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {

        return $this->render('movies/index.html.twig', [
            'movies' => $this->movieRepository->findAll()
        ]);
    }
    
    // #[Route('/movies/{id}', methods: ['GET'], name: 'show_movie')]
    // public function show($id): Response
    // {
    //     $movie = $this->movieRepository->find($id);
        
    //     return $this->render('movies/show.html.twig', [
    //         'movie' => $movie
    //     ]);
    // }

}
