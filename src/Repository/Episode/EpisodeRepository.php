<?php

namespace App\Repository\Episode;

use App\Entity\Episode\Episode;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Episode|null find($id, $lockMode = null, $lockVersion = null)
 * @method Episode|null findOneBy(array $criteria, array $orderBy = null)
 * @method Episode[]    findAll()
 * @method Episode[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EpisodeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Episode::class);
    }

    /**
     * Utiliser dans le controller episode pour générer une pagination.
     * @return Query
     */
    public function findAllQuery()
    {
        // peut optimisé la recherche pour renvoyer l'episode, image et le nom de l'anime seulement
        // avec la methode select
        $query = $this->createQueryBuilder('e')
            // ->select('e.slug') => pour l'url
            // ->select('e.anime.image') pour l'image de l'anime
            // ...
            ->orderBy('e.createdAt', 'DESC')
            ->getQuery();
        return $query;
        // return $this->findBy([/*critaire*/], ['createdAt' => 'DESC']);
    }

    // /**
    //  * @return Episode[] Returns an array of Episode objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Episode
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
