<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Emprunteur;
use App\Entity\Emprunt;
use App\Entity\Auteur;
use App\Entity\Genre;
use App\Entity\Livre;
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
        $this->loadGenres();
        $this->loadLivres();
        $this->loadEmprunteurs();
        $this->loadEmprunts();
    }

    //^------------------------FONCTION AUTEUR------------------------------

    public function loadAuteurs(): void
    {
        //* DONNÉES STATIQUES      

        $infos = [
            [
                'nom' => 'Cartier',
                'prenom' => 'Hugues',
            ],
            [
                'nom' => 'Lambert',
                'prenom' => 'Armand',
            ],
            [
                'nom' => 'Moitessier',
                'prenom' => 'Thomas',
            ],
        ];

        foreach ($infos as $info) {
            $auteur = new Auteur();
            $auteur
                ->setPrenom($info['prenom'])
                ->setNom($info['nom'])
            ;

            $this->manager->persist($auteur);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 500; $i++) {

            $auteur = new Auteur();

            $auteur
                ->setPrenom($this->faker->firstName())
                ->setNom($this->faker->lastName())
            ;

            $this->manager->persist($auteur);
        }

        $this->manager->flush();
    }


    //^-------------------FONCTION GENRE----------------------------------

    public function loadGenres(): void
    {
        //* DONNÉES STATIQUES
        $infos = [
            [
                'nom' => 'poésie',
                'description' => null,
            ],
            [
                'nom' => 'nouvelle',
                'description' => null,
            ],
            [
                'nom' => 'roman historique',
                'description' => null,
            ],
            [
                'nom' => "roman d'amour",
                'description' => null,
            ],
            [
                'nom' => "roman d'aventure",
                'description' => null,
            ],
            [
                'nom' => 'science-fiction',
                'description' => null,
            ],
            [
                'nom' => 'fantasy',
                'description' => null,
            ],
            [
                'nom' => 'biographie',
                'description' => null,
            ],
            [
                'nom' => 'conte',
                'description' => null,
            ],
            [
                'nom' => 'témoignage',
                'description' => null,
            ],
            [
                'nom' => 'théâtre',
                'description' => null,
            ],
            [
                'nom' => 'essai',
                'description' => null,
            ],
            [
                'nom' => 'journal intime',
                'description' => null,
            ],
        ];

        foreach ($infos as $info) {
            $genre = new Genre();
            $genre
                ->setNom($info['nom'])
                ->setDescription($info['description'])
            ;

            $this->manager->persist($genre);
        }

        $this->manager->flush();

    }

    //^---------------------FONCTION LIVRE-----------------------------------------   

    public function loadLivres(): void
    {
        //* RELATIONS
        // Genre
        $genreRepository = $this->manager->getRepository(Genre::class);
        $genres = $genreRepository->findAll();
        $genre1 = $genreRepository->find(1);
        $genre2 = $genreRepository->find(2);
        $genre3 = $genreRepository->find(3);
        $genre4 = $genreRepository->find(4);
        
        //Auteur
        $auteurRepository = $this->manager->getRepository(Auteur::class);
        $auteurs = $auteurRepository->findAll();
        $auteur1 = $auteurRepository->find(1);
        $auteur2 = $auteurRepository->find(2);
        $auteur3 = $auteurRepository->find(3);
        $auteur4 = $auteurRepository->find(4);

        //* DONNÉES STATIQUES      

        $infos = [
            [
                'titre' => 'Lorem ipsum dolor sit amet',
                'annee_edition' => 2010,
                'nombre_pages' => 100,
                'code_isbn' => '9785786930024',
                'auteur' => $auteur1,
                'genre' => [$genre1],
            ],
            [
                'titre' => 'Consectetur adipiscing elit',
                'annee_edition' => 2011,
                'nombre_pages' => 150,
                'code_isbn' => '9783817260935',
                'auteur' => $auteur2,
                'genre' => [$genre2],
            ],
            [
                'titre' => 'Mihi quidem Antiochum',
                'annee_edition' => 2012,
                'nombre_pages' => 200,
                'code_isbn' => '9782020493727',
                'auteur' => $auteur3,
                'genre' => [$genre3],
            ],
            [
                'titre' => 'Quem audis satis belle ',
                'annee_edition' => 2013,
                'nombre_pages' => 250,
                'code_isbn' => '9794059561353',
                'auteur' => $auteur4,
                'genre' => [$genre4],
            ],
        ];

        foreach ($infos as $info) {
            $livre = new Livre();
            $livre
                ->setTitre($info['titre'])
                ->setAnneeEdition($info['annee_edition'])
                ->setNombrePages($info['nombre_pages'])
                ->setCodeIsbn($info['code_isbn'])
                ->setAuteur($info['auteur'])
                ->addGenre($info['genre'][0])
            ;

            $this->manager->persist($livre);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 1000; $i++) {

            $livre = new Livre();

            $livre->setTitre($this->faker->words(1, 5));

            $livre->setAnneeEdition($this->faker->year());

            $livre->setNombrePages($this->faker->randomNumber(3, true));

            $livre->setCodeIsbn($this->faker->randomNumber(8, true));

            $auteur = $this->faker->randomElement($auteurs);
            $livre->setAuteur($auteur);

            $genre = $this->faker->randomElement($genres);
            $livre->addGenre($genre);

            $this->manager->persist($livre);
        }

        $this->manager->flush();

    }
    

    //^---------------------FONCTION EMPRUNTEUR-------------------------------------
    public function loadEmprunteurs(): void
    {
        //* RELATIONS
        $userRepository = $this->manager->getRepository(User::class);
        $users = $userRepository->findAll();
        $user1 = $userRepository->find(1);
        $user2 = $userRepository->find(2);
        $user3 = $userRepository->find(3);
        $user4 = $userRepository->find(4);

        //* DONNÉES STATIQUES      
        $infos = [
            [
                'email' => 'foo.foo@example.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => true,

                'nom' => 'foo',
                'prenom' => 'foo',
                'tel' => '123456789'
            ],
            [
                'email' => 'bar.bar@example.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => false,

                'nom' => 'bar',
                'prenom' => 'bar',
                'tel' => '123456789'
            ],
            [
                'email' => 'baz.baz@example.com',
                'roles' => ['ROLE_USER'],
                'password' => '123',
                'enabled' => true,

                'nom' => 'baz',
                'prenom' => 'baz',
                'tel' => '123456789'
            ],
        ];

        foreach ($infos as $info) {
            
            $user = new User();
            
            $password = $this->hasher->hashPassword($user, $info['password']);

            $user
            ->setEmail($info['email'])
            ->setPassword($password)
            ->setRoles($info['roles'])
            ->setEnabled($info['enabled'])
            ;
            
            $this->manager->persist($user);

            $emprunteur = new Emprunteur();

            $emprunteur
                ->setNom($info['nom'])
                ->setPrenom($info['prenom'])
                ->setTel($info['tel'])
                ->setUser($user)
            ;

            $this->manager->persist($emprunteur);
        }

        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 100; $i++) {

            $user = new User();
            $password = $this->hasher->hashPassword($user, '123');
            $user
                ->setEmail($this->faker->unique()->safeEmail())
                ->setPassword($password)
                ->setRoles(['ROLE_USER'])
                ->setEnabled($this->faker->boolean())
            ;

            $this->manager->persist($user);

            $emprunteur = new Emprunteur();
            $emprunteur
                ->setNom($this->faker->lastName())
                ->setPrenom($this->faker->firstName())
                ->setTel($this->faker->phoneNumber())
                ->setUser($user)
            ;

            $emprunteur->setUser($user);
            
            $this->manager->persist($emprunteur);
        }
        $this->manager->flush();
    }


    //^---------------------------FONCTION EMPRUNTS-----------------------------------------
    public function loadEmprunts(): void
    {
        //* RELATIONS
        // Emprunteur
        $emprunteurRepository = $this->manager->getRepository(Emprunteur::class);
        $emprunteurs = $emprunteurRepository->findAll();
        $emprunteur1 = $emprunteurRepository->find(1);
        $emprunteur2 = $emprunteurRepository->find(2);
        $emprunteur3 = $emprunteurRepository->find(3);
        // Livre
        $livreRepository = $this->manager->getRepository(Livre::class);
        $livres = $livreRepository->findAll();
        $livre1 = $livreRepository->find(1);
        $livre2 = $livreRepository->find(2);
        $livre3 = $livreRepository->find(3);        

        //* DONNÉES STATIQUES   
        $infos = [
            [
                'date_emprunt' => new DateTime('2020-02-01 10:00:00'),
                'date_retour' => null,
                'emprunteur_id' => [$emprunteur1],
                'livre_id' => [$livre1],
            ],
            [
                'date_emprunt' => new DateTime('2020-03-01 10:00:00'),
                'date_retour' => null,
                'emprunteur_id' => [$emprunteur2],
                'livre_id' => [$livre2],

            ],
            [
                'date_emprunt' => new DateTime('2020-04-01 10:00:00'),
                'date_retour' => new DateTime('2020-04-01 10:00:00'),
                'emprunteur_id' => [$emprunteur3],
                'livre_id' => [$livre3],
            ],
        ];

        foreach ($infos as $info) {
            $emprunt = new Emprunt();
            $emprunteur = $info['emprunteur_id'][0];
            $livre = $info['livre_id'][0];

            $emprunt
                ->setDateEmprunt($info['date_emprunt'])
                ->setDateRetour($info['date_retour'])
                ->setEmprunteur($emprunteur)
                ->setLivre($livre)
            ;

            $this->manager->persist($emprunt);
        }
        $this->manager->flush();

        //* DONNÉES DYNAMIQUES
        for ($i = 0; $i < 200; $i++) {

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
}