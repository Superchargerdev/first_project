<?php

namespace App\Controller;

use App\Repository\MovieRepository;
use App\Entity\Movie;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FirstController extends AbstractController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this -> em = $em;
    }
    #[Route('/first', name: 'app_first')]
    public function index(): Response
    {
        //findAll() - Select * FROM movies;
        //find() - Select * FROM movies WHERE id = 5;
        //findBy() - Select * FROM movies ORDER BY id DESC;
        //findOneBy - Select * FROM movies WHERE id = 6 AND title = 'The Dark Knight' ORDER BY id DESC;
        //count() - Select * FROM movies WHERE id = 5;
        // $repository = $this -> em -> getRepository(Movie::class)->findAll();
        // $movies = $repository;
        // dd($movies);
        return $this->render('index.html.twig');
    }
}
