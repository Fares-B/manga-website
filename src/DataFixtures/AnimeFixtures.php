<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

// use Doctrine\ORM\EntityManager;

use App\Entity\Anime;
use App\Entity\Kind;
use App\Entity\Type;
use App\Entity\Status;

use App\Entity\Episode;
use App\Entity\Voice;
use App\Entity\Format;

class AnimeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');

        

        // Kind
        $kin = ["Action","Aventure","Combat","Comédie","Drama","Ecchi","École","Enfant","Fantastique","Harem","Historique","Horreur","Josei","Magique","Mecha","Militaire","Musique","Mystère","Policier","Psychologique","Romance","Science-fiction","Sport","Super Pouvoir","Thriller","Tranche de vie"];

        foreach ($kin as $value) {
            $kind = new Kind();

            $kind->setName($value)
                 ->setCreatedAt(new \DateTime());

            $manager->persist($kind);
        }

        // Type
        $typ = ["Shonen","Shojo","Seinen","Kodomo"];
        foreach ($typ as $value) {
            $type = new Type();

            $type->setName($value)
                 ->setCreatedAt(new \DateTime());

            $manager->persist($type);
        }

        // Status
        $sta = ["En cours","Fini","Abandonné"];
        foreach ($sta as $value) {
            $status = new Status();

            $status->setName($value)
                 ->setCreatedAt(new \DateTime());

            $manager->persist($status);
        }

        $voi = ["Vostfr","VF"];
        foreach ($voi as $value) {
            $voice = new Voice();

            $voice->setName($value);

            $manager->persist($voice);
        }

        $fo = ["Vostfr","VF"];
        foreach ($fo as $value) {
            $format = new Format();

            $format->setName($value);

            $manager->persist($format);
        }


        // for ($i=1; $i < mt_rand(3, 8); $i++) { 
        //     $anime = new Anime();

        //     $name = $faker->word();

        //     $em = new EntityManager();
        //     $entityManager = $em->getDoctrine()->getManager();
        //     $repoType = $entityManager->getRepository("App\Entity\Type")->find(mt_rand(1, 4));
        //     $repoStatus = $entityManager->getRepository("App\Entity\Status")->find(mt_rand(1, 3));

        //     $anime->setTitle($name)
        //           ->setContent($faker->text($maxNbChars = 200))
        //           ->setPublished($faker->numberBetween(1990,2020))
        //           ->setType($repoType)
        //           ->setKind(['Aventure', 'Combat', 'Drame', 'Fantastique'])
        //           ->setStatus($repoStatus)
        //           ->setAlternativeTitle($faker->sentence())
        //           ->setAuthor($faker->name())
        //           ->setCountry($faker->country())
        //           ->setImage($faker->imageUrl())
        //           ->setSlug($name)
        //           ->setCreatedAt($faker->dateTimeBetween('-30 years'));
        //     // $manager->persisxt($anime);
        // }

        // $epi = [
        //     [
        //         'voice' => 'vostfr',
        //         'season'=> 1,
        //         'episode'=> 1,
        //         'format'=> 'Episode',
        //         'video' => ['1_url', '2_url'],
        //         'slug' => 'one-piece-saison-1-episode-1-vostfr'
        //     ],
        //     [
        //         'voice' => 'vostfr',
        //         'season'=> 2,
        //         'episode'=> 8,
        //         'format'=> 'Episode',
        //         'video' => ['1_url', '2_url'],
        //         'slug' => 'naruto-shippuden-saison-2-episode-8-vostfr'
        //     ],
        //     [
        //         'voice' => 'vf',
        //         'season'=> 1,
        //         'episode'=> 3,
        //         'format'=> 'Film',
        //         'video' => ['1_url', '2_url', '3_url', '4_url'],
        //         'slug' => 'jojo-saison-1-film-3-vf'
        //     ]
        // ];
        // foreach ($epi as $value) {
        //     $episode = new Episode();

        //     $episode->setVoice($value['voice'])
        //             ->setSeason($value['season'])
        //             ->setEpisode($value['episode'])
        //             ->setFormat($value['format'])
        //             ->setVideo($value['video'])
        //             ->setSlug($value['slug'])
        //             ->setCreatedAt(new \DateTime());

        //     $manager->persist($episode);
        // }

        $manager->flush();
    }
}
