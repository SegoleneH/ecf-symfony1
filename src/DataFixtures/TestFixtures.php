<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Emprunt;
use App\Entity\Emprunteur;
use App\Entity\Genre;
use App\Entity\Livre;
use App\Entity\User;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class TestFixtures extends Fixture implements FixtureGroupInterface
{
    private $faker;
    private $hasher;
    private $manager;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->faker = FakerFactory::create('fr_FR');
        $this->hasher = $hasher;
    }

    public static function getGroups(): array
    {
        return ['test'];
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadAuteurs();
        $this->loadEmprunts();
        $this->loadEmprunteurs();
        $this->loadGenres();
        $this->loadLivres();
        $this->loadUsers();
    }

    //^FONCTION AUTEUR   

    public function loadAuteurs() : void
    {
        //* RELATIONS
        // Auteur<--
        // $auteurRepository = $this->manager->getRepository(Auteur::class);
        // $auteurs = $auteurRepository->findAll();
        // $auteur3 = $auteurRepository->find(1);
        // $auteur2 = $auteurRepository->find(2);
        // $auteur3 = $auteurRepository->find(3);
        // Livre
        // $livreRepository = $this->manager->getRepository(Livre::class);
        // $livres = $livreRepository->findAll();
        // $livre1 = $livreRepository->find(1);
        // $livre2 = $livreRepository->find(2);
        // $livre3 = $livreRepository->find(3);

        //* DONNÉES STATIQUES      

        $infos = [
            [
                'nom' => 'Paul',
                'prenom' => 'Longjohn',
            ],
            [
                'nom' => 'Paul Junior',
                'prenom' => 'Longjohn',
            ],
            [
                'nom' => 'Paolito',
                'prenom' => 'Longjohn',
            ],
        ];

        foreach ($infos as $info) {
            $auteur = new Auteur();
            $auteur->setPrenom($info['prenom']);
            $auteur->setNom($info['nom']);

            $this->manager->persist($auteur);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 10; $i++) {

            $auteur = new Auteur();

            $auteur->setPrenom($this->faker->firstName());
            
            $auteur->setNom($this->faker->lastName());

            $this->manager->persist($auteur);
        }

        $this->manager->flush();
    }


    //^FONCTION GENRE 

    public function loadGenres(): void
    {
        //* RELATIONS
        // Genre<--
        // $genreRepository = $this->manager->getRepository(Genre::class);
        // $genres = $genreRepository->findAll();
        // $genre1 = $genreRepository->find(1);
        // $genre2 = $genreRepository->find(2);
        // $genre3 = $genreRepository->find(3);
        // Livre
        // $livreRepository = $this->manager->getRepository(Livre::class);
        // $livres = $livreRepository->findAll();
        // $livre1 = $livreRepository->find(1);
        // $livre2 = $livreRepository->find(2);
        // $livre3 = $livreRepository->find(3);

        //* DONNÉES STATIQUES      

        $infos = [
            [
                'nom' => 'Romans',
                'description' => 'Reprehenderit porro non ut placeat harum, modi quidem.',
                // 'livres' => [$livre1],
            ],
            [
                'nom' => 'Encyclopédies',
                'description' => 'Reprehenderit porro non ut placeat harum, modi quidem.',
                // 'livres' => [$livre2],
            ],
            [
                'nom' => 'Dictionnaires',
                'description' => 'Reprehenderit porro non ut placeat harum, modi quidem.',
                // 'livres' => [$livre3],
            ],
        ];

        foreach ($infos as $info) {
            $genre = new Genre();
            $genre->setNom($info['nom']);
            $genre->setDescription($info['description']);

            // $livre = $info['livres'][0];
            // $genre->addLivre

            $this->manager->persist($genre);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 10; $i++) {

            $genre = new Genre();

            $genre->setNom($this->faker->words(1,3));

            $genre->setDescription($this->faker->sentence(1,3));

            $this->manager->persist($genre);
        }

        $this->manager->flush();
    }


    //^FONCTION LIVRE   

    public function loadLivres() : void 
    {
        //* RELATIONS
        // Livre<--
        // $livreRepository = $this->manager->getRepository(Emprunteur::class);
        // $livres = $livreRepository->findAll();
        // $livre1 = $livreRepository->find(1);
        // $livre2 = $livreRepository->find(2);
        // $livre3 = $livreRepository->find(3);
        // Genre
        $genreRepository = $this->manager->getRepository(Genre::class);
        $genres = $genreRepository->findAll();
        $genre1 = $genreRepository->find(1);
        $genre2 = $genreRepository->find(2);
        $genre3 = $genreRepository->find(3);
        // Auteur
        $auteurRepository = $this->manager->getRepository(Genre::class);
        $auteurs = $auteurRepository->findAll();
        $auteur1 = $auteurRepository->find(1);
        $auteur2 = $auteurRepository->find(2);
        $auteur3 = $auteurRepository->find(3);

        //* DONNÉES STATIQUES      

        $infos = [
            [
                'titre' => 'La momie',
                'annee_edition' => '1977',
                'nombre_pages' => '327',
                'code_isbn' => '45789621',
                'auteur' => [$auteur1],
                'genre' => [$genre1],
            ],
            [
                'titre' => 'Les plantes vertes',
                'annee_edition' => '1991',
                'nombre_pages' => '296',
                'code_isbn' => '45851024',
                'auteur' => [$auteur2],
                'genre' => [$genre2],
            ],
            [
                'titre' => 'Dictionnaire des meilleures données',
                'annee_edition' => '2001',
                'nombre_pages' => '354',
                'code_isbn' => '56823691',
                'auteur' => [$auteur3],
                'genre' => [$genre3],
            ],
        ];

        foreach ($infos as $info) {
            $livre = new Livre();
            $livre->setTitre($info['titre']);
            $livre->setAnneeEdition($info['annee_edition']);
            $livre->setCodeIsbn($info['code_isbn']);

            $auteur = $info['auteur'][0];
            $livre->setAuteur($auteur);

            $genre = $info['genre'][0];
            $livre->addGenre($genre);

            $this->manager->persist($livre);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 10; $i++) {

            $livre = new Livre();

            $livre->setTitre($this->faker->words(1,5));

            $livre->setAnneeEdition($this->faker->year());

            $livre->setCodeIsbn($this->faker->randomNumber(8, true));

            $auteur = $this->faker->randomElement($auteurs);
            $livre->setAuteur($auteur);

            $genre = $this->faker->randomElement($genres);
            $livre->addGenre($genre);

            $this->manager->persist($livre);
        }

        $this->manager->flush();

    }

    //^ FONCTION EMPRUNTEUR
    public function loadEmprunteurs(): void
    {
        //* RELATIONS
        // Emprunteur<--
        // $EmprunteurRepository = $this->manager->getRepository(Emprunteur::class);
        // $emprunteurs = $EmprunteurRepository->findAll();
        // User
        $userRepository = $this->manager->getRepository(User::class);
        $users = $userRepository->findAll();
        $user1 = $userRepository->find(1);
        $user2 = $userRepository->find(2);
        $user3 = $userRepository->find(3);

        //* DONNÉES STATIQUES      

        $infos = [
            [
                'nom' => 'foo',
                'prenom' => 'foo',
                'tel' => '0756655982',
                'user' => [$user1]
            ],
            [
                'nom' => 'bar',
                'prenom' => 'bar',
                'tel' => '0756795982',
                'user' => [$user2]
            ],
            [
                'nom' => 'baz',
                'prenom' => 'baz',
                'tel' => '0774455963',
                'user' => [$user3]
            ],
        ];

        foreach ($infos as $info) {
            $emprunteur = new Emprunteur();
            
            $emprunteur->setNom($info['nom']);
            $emprunteur->setPrenom($info['prenom']);
            $emprunteur->setTel($info['tel']);
            
            $user = $info['user'][0];
            $emprunteur->setUser($user);

           $this->manager->persist($emprunteur);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 10; $i++) {

            $emprunteur = new Emprunteur();

            $emprunteur->setNom($this->faker->lastName());

            $emprunteur->setPrenom($this->faker->firstName());

            $emprunteur->setTel($this->faker->e164PhoneNumber());

            $user = $this->faker->randomElement($users);
            $emprunteur->setUser($user);

            $this->manager->persist($emprunteur);
        }
        $this->manager->flush();
    }

    //^ FONCTION EMPRUNT
    public function loadEmprunts(): void
    {
        //* RELATIONS
        // Emprunt<--
        // $empruntRepository = $this->manager->getRepository(Emprunt::class);
        // $emprunts = $empruntRepository->findAll();
        // $emprunt1 = $empruntRepository->find(1);
        // $emprunt2 = $empruntRepository->find(2);
        // $emprunt3 = $empruntRepository->find(3);

//!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//! In ExceptionConverter.php line 114:
                                                                                         
//!   [Doctrine\DBAL\Exception\NotNullConstraintViolationException (1048)]                     
//!   An exception occurred while executing a query: SQLSTATE[23000]: Integrity constraint vi  
//!   olation: 1048 Column 'emprunteur_id' cannot be null  

//!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//! In Statement.php line 121:

//!   [PDOException (23000)]                                                                   
//!   SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'emprunteur_id' cannot be   
//!   null  

//!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//! Exception trace:
//!  Doctrine\ORM\EntityManager->flush() at ../DataFixtures/TestFixtures.php:412
//!  App\DataFixtures\TestFixtures->loadEmprunts() at ../DataFixtures/TestFixtures.php:39

//!---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

    // Emprunteur
        $emprunteurRepository = $this->manager->getRepository(Emprunteur::class);
        $emprunteurs = $emprunteurRepository->findAll();
        $emprunteur1 = $emprunteurRepository->find(1);
        $emprunteur2 = $emprunteurRepository->find(2);
        $emprunteur3 = $emprunteurRepository->find(3);
        //* Livre
        $livreRepository = $this->manager->getRepository(Livre::class);
        $livres = $livreRepository->findAll();
        $livre1 = $livreRepository->find(1);
        $livre2 = $livreRepository->find(2);
        $livre3 = $livreRepository->find(3);        

        //* DONNÉES STATIQUES   
        $infos = [
            [
                'date_emprunt' => new DateTime('2022-12-31'),
                'date_retour' => null,
                'emprunteur_id' => [$emprunteur1],
                'livre_id' => [$livre1],
            ],
            [
                'date_emprunt' => new DateTime('2022-08-28'),
                'date_retour' => null,
                'emprunteur_id' => [$emprunteur2],
                'livre_id' => [$livre2],

            ],
            [
                'date_emprunt' => new DateTime('2022-10-15'),
                'date_retour' => new DateTime('2022-12-18'),
                'emprunteur_id' => [$emprunteur3],
                'livre_id' => [$livre3],
            ],
        ];

        foreach ($infos as $info) {
            $emprunt = new Emprunt();
            $emprunt->setDateEmprunt($info['date_emprunt']);
            $emprunt->setDateRetour($info['date_retour']);

            $emprunteur = $info['emprunteur_id'][0];
            $emprunt->setEmprunteur($emprunteur);

            $livre = $info['livre_id'][0];
            $emprunt->setLivre($livre);

            $this->manager->persist($emprunt);
        }
        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 10; $i++) {

            $emprunt = new Emprunt();

            $dateEmprunt = $this->faker->dateTimeBetween('-7 months', 'now');
            $emprunt->setDateEmprunt($dateEmprunt);
            
            $dateRetour = $this->faker->dateTimeBetween('-7 years', 'now');
            $emprunt->setDateRetour($dateRetour);

            $emprunteur = $this->faker->randomElement($emprunteurs);
            $emprunt->setEmprunteur($emprunteur);

            $livre = $this->faker->randomElement($livres);
            $emprunt->setLivre($livre);

            $this->manager->persist($emprunt);
        }
        $this->manager->flush();
    }

    //^ FONCTION USERS
    public function loadUsers(): void
    {

        //* RELATIONS
        // User<--
        $userRepository = $this->manager->getRepository(User::class);
        // $users = $userRepository->findAll();

        // Emprunteur
        $emprunteurRepository = $this->manager->getRepository(Emprunteur::class);
        $emprunteurs = $emprunteurRepository->findAll();
        $emprunteur1 = $emprunteurRepository->find(1);
        $emprunteur2 = $emprunteurRepository->find(2);
        $emprunteur3 = $emprunteurRepository->find(3);

        //* DONNÉES STATIQUES

        $infos = [
            [
                'email' => 'foo.foo@example.com',
                'password' => '123',
                'roles' => ['ROLE_USER'],
                'enabled' => false,
                'emprunteur' => [$emprunteur1],
            ],
            [
                'email' => 'bar.bar@example.com',
                'password' => '123',
                'roles' => ['ROLE_USER'],
                'enabled' => false,
                'emprunteur' => [$emprunteur2],
            ],
            [
                'email' => 'baz.baz@example.com',
                'password' => '123',
                'roles' => ['ROLE_USER'],
                'enabled' => false,
                'emprunteur' => [$emprunteur3],
            ],
        ];

        foreach ($infos as $info) {
            $user = new User();
            $user->setEmail($info['email']);
            $password = $this->hasher->hashPassword($user, $info['password']);
            $user->setPassword($password);
            $user->setEnabled($info['enabled']);
            $user->setRoles($info['roles']);

            $emprunteur = $info['emprunteur'][0];
            $user->setEmprunteur($emprunteur);

            $this->manager->persist($user);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 10; $i++) {

            $user = new User();

            $user->setEmail($this->faker->email());

            $password = $this->hasher->hashPassword($user, '123');
            $user->setPassword($password);

            $user->setRoles(['ROLE_USER']);

            $user->setEnabled($this->faker->boolean());

            $emprunteur = $this->faker->randomElement($emprunteurs);
            $user->setEmprunteur($emprunteur);

            $this->manager->persist($user);
        }
        $this->manager->flush();
    }
}