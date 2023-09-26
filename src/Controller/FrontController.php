<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LivreRepository;
use App\Repository\GenreRepository;
use App\Entity\Livre;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(LivreRepository $livreRepository): Response
    {
        $livres = $livreRepository->findAll();

        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            'livres' => $livres,
        ]);
    }

    #[Route('/livre/{id}', name: 'app_front_livre_show')]
    public function livreShow(Livre $livre, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();

        $genres = $livre->getGenre();



        return $this->render('front/livre_show.html.twig', [
            'livre' => $livre,
            'genres' => $genres,
        ]);
    }
}
