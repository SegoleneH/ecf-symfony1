<?php

namespace App\Controller;

use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;
use Date;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test')]
class TestController extends AbstractController
{
    /**
     * Summary of user
     * @param \Doctrine\Persistence\ManagerRegistry $doctrine
     * @return \Symfony\Component\HttpFoundation\Response
     */
    #[Route('/user', name: 'app_test_user')]
    public function user(ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $userRepository = $em->getRepository(User::class);

        // Liste complète des users triée par ordre alphabétique
        $users = $userRepository->findAll();

        // Données de l'user dont l'id est 1
        $user1 = $userRepository->find(1);

        // Données de l'user dont l'email est foo.foo@example.com
        $fooEmail = $userRepository->findByEmail('foo.foo@example.com');

        // Liste des users dont le role est "ROLE_USER", 
        // triée par ordre alphabétique d'email
        $userRole = $userRepository->findUsersByRole('ROLE_USER');

        // Liste des users inactifs triée par ordre alphabétique d'email
        $userActivity = $userRepository->findByEnabled(false);

        //* 
        return $this->render('test/user.html.twig', [
            'controller_name' => 'TestController',
            'users' => $users,
            'user1' => $user1,
            'fooEmail' => $fooEmail,
            'userRole' => $userRole,
            'userActivity' => $userActivity,
        ]);
    }
}
//*---------------------------------------------------------------------------        
/*
//Récupération de l'objet "tag" dont l'id est 4.
$tag4 = $tagRepository->find(4);
$tag4->setName('Python');
$tag4->setDescription(null);
$em->flush();


//Association du tag 4 au student 1.
        $student->addTag($tag4);
        $em->flush();

        // Récupération des tags contenant certains mots clés
        $keywordTags1 = $tagRepository->findByKeyword('HTML');
        $keywordTags2 = $tagRepository->findByKeyword('CSS');

        // Récupération de tags à partir d'une schoolYear
        $schoolYearRepository = $em->getRepository(SchoolYear::class);
        $schoolYear = $schoolYearRepository->find(1);
        $schoolYearTags = $tagRepository->findBySchoolYear($schoolYear);

        //mise à jour des relations d'un tag
        $studentRepository = $em->getRepository(Student::class);
        $student = $studentRepository->find(2);
        $htmlTag = $tagRepository->find(1);
        $htmlTag->addStudent($student);
        $em->flush();
        //*--------------------------------------------------------------------------     
        
*/