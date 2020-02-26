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
     * Filtre les animes en fonction du choix de l'utilisateur
     * @return Query
     */
    public function searchAnime($criteria)
    {
        $query = $this->createQueryBuilder('a');
                    //   ->select('a.title', 'a.slug', 'a.image');
        // cherche un titre dans la bdd anime contenant un critère à rechercher
        if (!empty($criteria['title'])) {
            $query->andWhere('a.title LIKE :title OR a.alternative_title LIKE :title')
                  ->setParameter('title' , '%'. $criteria['title'] .'%');
        }

        // ajouter une option vide par default sur les formulaire pour ensuite ne pas rechercher si la valeur est vide
        if(!empty($criteria['type'])) {
            $query->andWhere('a.type = :type')
                    ->setParameter('type' , $this->getTypeOf($criteria['type']));
        }

        if(!empty($criteria['status'])) {
            $query->andWhere('a.status = :status')
                    ->setParameter('status' , $this->getTypeOf($criteria['status']));
        }

        if(!empty($criteria['kind'])) {
            // J'ai réglé le problème en concaténant le nom du parametre (:k) avec un index ($i) qui change à chaque fin de boucle.
            // et en mettant en place la jointure dans la boucle
            for ($i=0; $i < count($criteria['kind']); $i++) {
                $k = 'k'.$i;
                $query->leftJoin('a.kind', $k);
                $query->andWhere($query->expr()->eq($k, ':'.$k))
                      ->setParameter($k, $this->getTypeOf($criteria['kind'][$i]));
            }

            // Continuer de rechercher une solution sans devoir créer plusieurs jointures
            // $query->leftJoin('a.kind', 'k');

            // $kindArray = $this->kindArray($criteria['kind']);

            // $query->andWhere($query->expr()->in('k', ':kinds'))
            //       ->setParameter('kinds', $kindArray);
            
        }

        if(!empty($criteria['publishedMin'])) {
            $query->andWhere('a.published >= :min')
                    ->setParameter('min' , $criteria['publishedMin']);
        }
        if(!empty($criteria['publishedMax'])) {
            $query->andWhere('a.published <= :max')
                    ->setParameter('max' , $criteria['publishedMax']);
        }

        if(!empty($criteria['author'])) {
            $query->andWhere('a.author LIKE :author')
                  ->setParameter('author' , '%' .$criteria['author']. '%');
        }

        if(!empty($criteria['country'])) {
            $query->andWhere('a.country = :country')
                  ->setParameter('country' , $criteria['country']);
        }

        return $query->orderBy('a.title', 'ASC')->getQuery()->getResult();
    }

    public function findAnimeTitle($title)
    {
        $query = $this->createQueryBuilder('a');

        if ($title) {
            $query->select('a.title', 'a.slug')
                  ->andWhere('a.title LIKE :title OR a.alternative_title LIKE :title')
                  ->setParameter('title' , '%'. $title .'%');
        }
        // Revoir l'ordre des elements
        return $query->orderBy('a.title', 'ASC')->setMaxResults(10)->getQuery()->getResult();
    }

    public function getTypeOf($criteria)
    {
        // si c'est une chainef
        if(is_string($criteria)) {
            return $criteria;
        }
        // si c'est un objet
        return $criteria->getId();
    }

    // /**
    //  * @return array
    //  */
    // private function kindArray($object): Array
    // {
    //     $kindArray = [];
    //     foreach ($object as $value) {
    //         $kindArray[] = $value->getId();
    //     }
    //     return $kindArray;
    // }

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
