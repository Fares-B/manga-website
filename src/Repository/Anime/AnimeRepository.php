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
    public function searchAnime($criteria)
    {
        $query = $this->createQueryBuilder('a');
        // cherche un titre dans la bdd anime contenant un critère à rechercher
        if ($criteria['title']) {
            $query->andWhere('a.title LIKE :title')
                  ->setParameter('title' , '%'. $criteria['title'] .'%');
        }

        // ajouter une option vide par default sur les formulaire pour ensuite ne pas rechercher si la valeur est vide
        if($criteria['type']) {
            $query->andWhere('a.type = :type')
                    ->setParameter('type' , $criteria['type']->getId());
        }

        if($criteria['status']) {
            $query->andWhere('a.status = :status')
                    ->setParameter('status' , $criteria['status']->getId());
        }

        // Gros problème !
        // pour un critère avec plusieurs choix // pour les kind
        // erreur dans les conditions where
        // affiche des resultats inattendus
        if($criteria['kind']) {
            // Jointure car ici nous avons une besoin d'une table qui est une relation entre kind et anime (ManyToMany)
            $query->leftJoin('a.kind', 'k')
                  ->addSelect('k');

            foreach ($criteria['kind'] as $kind) {
                $query->andWhere($query->expr()->eq('k', ':k'))
                      ->setParameter('k', $kind->getId());
            }
        }

        // Pour la date de parution utiliser
        // $qb->expr()->between('u.id', ':dateMin', ':dateMax');

        // ->setMaxResults(10) // le paginator prends le relais, mais pour une api je limiterai le nombre de resultat 
        return $query->orderBy('a.title', 'ASC')->getQuery();
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
