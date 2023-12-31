<?php

namespace App\Repository;

use App\Entity\Emprunteur;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Emprunteur>
 *
 * @method Emprunteur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Emprunteur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Emprunteur[]    findAll()
 * @method Emprunteur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EmprunteurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Emprunteur::class);
    }
    
    /**
     * This Method return all emprunteur ordered by lastname and firstname
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findAllEmprunteurOrderByNameAndFirstName(): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * This method finds all Emprunteur containing a keyword anywhere in the name or firstname
     * @param string $keyword The keyword to search for
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findEmprunteurByKeyword(string $keyword): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.nom LIKE :keyword')
            ->orWhere('e.prenom LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * This method finds all Emprunteur containing a keyword anywhere in the tel number
     * @param string $keyword The keyword to search for
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findEmprunteurByKeywordInTel(string $keyword): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.tel LIKE :keyword')
            ->setParameter('keyword', "%$keyword%")
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * This method finds all Emprunteur created before a specific date
     * @param DateTime $date The date to search for
     * @return Emprunteur[] Returns an array of Emprunteur objects
     */
    public function findEmprunteurByDateCreatedAt(DateTime $date): array
    {
        return $this->createQueryBuilder('e')
            ->select('e')
            ->Where('e.createdAt < :date')
            ->setParameter('date', $date)
            ->orderBy('e.nom, e.prenom', 'ASC')
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Emprunteur[] Returns an array of Emprunteur objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Emprunteur
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
