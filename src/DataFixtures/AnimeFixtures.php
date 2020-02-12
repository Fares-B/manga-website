<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Anime;
use App\Entity\Episode;

class AnimeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $arr = [
            [
                'title' => 'One Piece',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam illo incidunt architecto similique itaque quis nisi officia explicabo libero! Molestiae?',
                'published' => 1999,
                'type' => 'Shonen',
                'kind' => ['Aventure', 'Combat', 'Comédie'],
                'status' => 'En cours',
                'alternative_title' => 'ワンピース',
                'author' => 'Eiichirō Oda',
                'country' => 'Japon',
                'image' => 'https://image.adkami.com/3.jpg',
                'slug' => 'one-piece'
            ],
            [
                'title' => 'Hunter x hunter',
                'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Incidunt minima earum laudantium vero eligendi numquam nam, totam dolore quam et!',
                'published' => 2011,
                'type' => 'Shonen',
                'kind' => ['Aventure', 'Combat', 'Drame', 'Fantastique'],
                'status' => 'Fin',
                'alternative_title' => 'Hunter hunter',
                'author' => 'Yoshihiro Togashi',
                'country' => 'Japon',
                'image' => 'https://image.adkami.com/34.jpg?1510262416',
                'slug' => 'hunter-x-hunter'
            ]
        ];

        foreach ($arr as $value) {
            $anime = new Anime();
            $anime->setTitle($value['title'])
                ->setContent($value['content'])
                ->setPublished($value['published'])
                ->setType($value['type'])
                ->setKind($value['kind'])
                ->setStatus($value['status'])
                ->setAlternativeTitle($value['alternative_title'])
                ->setAuthor($value['author'])
                ->setCountry($value['country'])
                ->setImage($value['image'])
                ->setSlug($value['slug'])
                ->setCreatedAt(new \DateTime());

            $manager->persist($anime);
        }

        $epi = [
            [
                'voice' => 'vostfr',
                'season'=> 1,
                'episode'=> 1,
                'format'=> 'Episode',
                'video' => ['1_url', '2_url'],
                'slug' => 'one-piece-saison-1-episode-1-vostfr'
            ],
            [
                'voice' => 'vostfr',
                'season'=> 2,
                'episode'=> 8,
                'format'=> 'Episode',
                'video' => ['1_url', '2_url'],
                'slug' => 'naruto-shippuden-saison-2-episode-8-vostfr'
            ],
            [
                'voice' => 'vf',
                'season'=> 1,
                'episode'=> 3,
                'format'=> 'Film',
                'video' => ['1_url', '2_url', '3_url', '4_url'],
                'slug' => 'jojo-saison-1-film-3-vf'
            ]
        ];
        foreach ($epi as $value) {
            $episode = new Episode();

            $episode->setVoice($value['voice'])
                    ->setSeason($value['season'])
                    ->setEpisode($value['episode'])
                    ->setFormat($value['format'])
                    ->setVideo($value['video'])
                    ->setSlug($value['slug'])
                    ->setCreatedAt(new \DateTime());

            $manager->persist($episode);
        }

        $manager->flush();
    }
}
