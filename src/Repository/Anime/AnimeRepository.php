<?php

namespace App\Repository\Anime;

use App\Entity\Anime\Anime;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Anime|null find($id, $lockMode = null, $lockVersion = null)
 * @method Anime|null findOneBy(array $criteria, array $orderBy = null)
 * @method Anime[]    findAll()
 * @method Anime[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Anime::class);
    }

    /**
     * Utiliser dans le controller anime pour générer une pagination.
     * @return Query
     */
    public function findAllQuery()
    {
        // peut optimisé la recherche pour renvoyer que le nom, slug, parution, image, count Episode, getLastEpisode
        // avec la methode select
        // utiliser plutot les groups dans les entity pour n'avoir que les elements souhaiter
        $query = $this->createQueryBuilder('a')
            // ->select('e.title')
            // ...
            ->orderBy('a.title', 'ASC')
            ->getQuery();
        return $query;
    }

    /**
     * @return Query
     */
    public function likeAnime($criteria)
    {
        // cherche un titre dans la bdd anime contenant un critère à rechercher
        return $this->createQueryBuilder('a')
            ->where('a.title LIKE :title')
            ->setParameter('title' , '%'. $criteria['title'] .'%')
            ->orderBy('a.title', 'ASC')
            // ->setMaxResults(10) // le paginator prends le relais, mais pour une api je limiterai le nombre de resultat 
            ->getQuery()
        ;
    }

    // /**
    //  * @return Anime[] Returns an array of Anime objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Anime
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
