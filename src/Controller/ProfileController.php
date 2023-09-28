<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Emprunteur;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

class ProfileController extends AbstractController
{
    #[Route('/profile/{id}', name: 'app_profile_index')]
    public function index(Emprunteur $emprunteur, User $user): Response
    {
        $emprunteur = $user->getEmprunteur();
        $emprunts = $emprunteur->getEmprunts();

        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'emprunts' => $emprunts,
        ]);
    }
}
