<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 *
 * @implements PasswordUpgraderInterface<User>
 *
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $user::class));
        }

        $user->setPassword($newHashedPassword);
        $this->getEntityManager()->persist($user);
        $this->getEntityManager()->flush();
    }

    /**
     * This method find all user ordered by email
     * @return User[] Returns an array of User objects
     */
    public function findAllUsersOrderByMail(): array
    {
        return $this->createQueryBuilder('u')
            ->select('u')
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }
    /**
     * This method find a user with a specific email
     * @param string $email The email to search for
     * @return User[] Returns an array of User objects
     */
    public function findByEmail(string $email): array
    {
        return $this->createQueryBuilder('u')
            ->setParameter('email', "%$email%")
            ->andWhere('u.email LIKE :email')
            ->getQuery()
            ->getResult();
    }
    /**
     * This method find all users whose role is ROLE_USER ordered by email
     * @return User[] Returns an array of User objects
     */
    // public function findUsersByRole(?string $userRole): array
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.roles LIKE :val')
    //         ->setParameter('val', "%$userRole%")
    //         ->orderBy('u.email', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }

    public function allRoleUser(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.roles LIKE :roles')
            ->setParameter('roles', '%ROLE_USER%')
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * This method find all non active users
     * @return User[] Returns an array of User objects
     */
    // public function findUsersByEnabled(): array
    // {
    //     return $this->createQueryBuilder('u')
    //         ->andWhere('u.enabled = 0')
    //         ->orderBy('u.email', 'ASC')
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }
    public function falseEnabled(): array
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.enabled = :false')
            ->setParameter('false', false)
            ->orderBy('u.email', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findByEmprunteur(Emprunteur $emprunteur): array
    {
        return $this->createQueryBuilder('u')
            ->innerJoin('u.emprunteur', 'e')
            ->andWhere('e = :e')
            ->setParameter('e', $emprunteur)
            ->orderBy('s.firstName', 'ASC')
            ->addOrderBy('s.lastName', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

    //    public function findOneBySomeField($value): ?User
//    {
//        return $this->createQueryBuilder('u')
//            ->andWhere('u.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}