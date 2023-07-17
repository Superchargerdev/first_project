<?php

namespace App\Controller;

use App\Entity\Movie;
use App\Form\MovieFormType;
use App\Repository\MovieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;

class FirstController extends AbstractController
{
    // private $em;
    // private $movieRepository;
    // public function __construct(EntityManagerInterface $em, MovieRepository $movieRepository) 
    // {
    //     $this->em = $em;
    //     $this->movieRepository = $movieRepository;
    // }
    private $em;
    private $movieRepository;
    public function __construct(MovieRepository $movieRepository, EntityManagerInterface $em)
    {
        $this->movieRepository = $movieRepository;
        $this->em=$em;
    }

    #[Route('/movies', name: 'movies')]
    public function index(): Response
    {

        return $this->render('movies/index.html.twig', [
            'movies' => $this->movieRepository->findAll()
        ]);
    }
    #[Route('/movies/create', name: 'create_movie')]
    public function create(Request $request): Response
    {
        $movie = new Movie();
        $form = $this -> createForm(MovieFormType::class, $movie);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $newMovie = $form->getData();
            $imagePath = $form->get('imagePath')->getData();
            if($imagePath){
                $newFileName = uniqid(). '.'. $imagePath->guessExtension();
                try{
                    $imagePath->move(
                        $this->getParameter('kernel.project_dir').'/public/uploads',
                        $newFileName
                    );
                }
                catch(FileException $e){
                    return new Response ($e->getMessage());
                }
                $newMovie->setImagePath('/uploads/'.$newFileName);
            }
            $this->em->persist($newMovie);
            $this->em->flush();
            return $this->redirectToRoute('movies');
        }

        return $this->render('movies/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/movies/edit/{id}', name: 'edit_movie')]
    public function edit($id, Request $request):Response{
        $movie = $this->movieRepository->find($id);
        $form = $this->createForm(MovieFormType::class, $movie);
        $form->handleRequest($request);
        $imagePath = $form->get('imagePath')->getData();
        if($form->isSubmitted() && $form->isValid()){
            if($imagePath){
                if($movie->getImagePath() !== null){
                    // if(file_exists($this->getParameter('kernel.project_dir').$movie->getImagePath())){
                        $this->GetParameter('kernel.project_dir').$movie->getImagePath();
                        $newFileName = uniqid(). '.' . $imagePath->guessExtension();
                        try{
                            $imagePath->move(
                                $this->getParameter('kernel.project_dir').'/public/uploads',
                                $newFileName
                            );
                        }
                        catch(FileException $e){
                            return new Response ($e->getMessage());
                        }
                        $movie -> setImagePath('/uploads/'. $newFileName);
                        $movie->setTitle($form->get('title')->getData());
                        $movie->setReleaseYear($form->get('releaseYear')->getData());
                        $movie->setDescription($form->get('description')->getData());
                        $this->em->flush();
                    // }
                }
            }
            else{
                $movie->setTitle($form->get('title')->getData());
                $movie->setReleaseYear($form->get('releaseYear')->getData());
                $movie->setDescription($form->get('description')->getData());
                $this->em->flush();
            }
            return $this->redirectToRoute('movies');
        }
        return $this->render('movies/edit.html.twig', [
            'movie' => $movie,
            'form' => $form->createView()
        ]);
    }
    #[Route('/movies/{id}', methods: ['GET'], name: 'show_movie')]
    public function show($id): Response
    {
        $movie = $this->movieRepository->find($id);
        
        return $this->render('movies/show.html.twig', [
            'movie' => $movie
        ]);
    }

}
