<?php

namespace App\DataFixtures;

use \PDO;

use Cocur\Slugify\Slugify;

/**
 * Utile que pour les tests
 * Permet de remplir la base de donnée avec des données fictives
 * Cependantn les kinds (tag) n'ont pas été créer.
 */
class FixturesAnimesEpisodes  {
    private $pdo;
    private $faker;
    private $slugify;

    public function __construct()
    {
        $this->pdo = $this->getPdo();
        $this->faker = \Faker\Factory::create('fr_FR');
        // ajout d'un package à faker pour générer des liens youtube
        $this->faker->addProvider(new \Faker\Provider\Youtube($this->faker));
        $this->slugify = new Slugify();
    }

    public function generate(): void
    {
        $sql = "INSERT INTO anime(title, content, published, type_id, status_id, alternative_title, author, country, image, slug, created_at)
                    VALUES (:title, :content, :published, :type_id, :status_id, :alternative_title, :author, :country, :image, :slug, :created_at)
        ";
        // $animesArray = (array)$this->getAnime();
        

        for($i = 1; $i <= 1; $i++) {
            $stmt= $this->pdo->prepare($sql);
            $anime = $this->getAnime();
            $stmt->execute($anime);
            $lastId = $this->pdo->lastInsertId();
            // créer des episodes
            $episdes = $this->generateEpisodes($anime, $lastId);
        }
    }

    /**
     * Génére plusieur episodes
     * @return void
     */
    private function generateEpisodes($anime, $anime_id): void
    {

        $sql = "
        INSERT INTO episode(anime_id, voice_id, format_id, season, episode, video, created_at, slug)
        VALUES(:anime_id, :voice_id, :format_id, :season, :episode, :video, :created_at, :slug)
        ";

        for($i = 0; $i < $this->faker->numberBetween(11, 26); $i++) {
            $stmt= $this->pdo->prepare($sql);
            $episode = $this->getEpisode($anime, $anime_id);
            $stmt->execute($episode);
        }
    }
    
    /**
     * Génére un anime
     * @return array
     */
    private function getAnime(): array
    {
        $title = $this->faker->company();
        // Génere des couleurs aléatoire pour notre image
        // substr pour supprimer le # car l'url ne marche pas avec
        $textColor = substr($this->faker->hexcolor(), 1);
        $backGroundColor = substr($this->faker->hexcolor(), 1);

        // transforme l'objet date en chaine
        $date = $this->faker->dateTimeBetween('-30 years')->format('Y-m-d H:i:s');
        return [
            "title" => $title,
            "content" => $this->faker->realText(200),
            "published" => $this->faker->numberBetween(1990, 2020),
            "type_id" => $this->faker->numberBetween(1, 4),
            "status_id" => $this->faker->numberBetween(1, 2),
            "alternative_title" => $this->faker->sentence(),
            "author" => $this->faker->name(),
            "country" => $this->faker->country(),
            "image" => "https://via.placeholder.com/250/$backGroundColor/$textColor?Text=$title",
            "slug" => $this->slugify->slugify($title),
            "created_at" => $date
        ];
    }
    
    /**
     * Génére un episode
     * @return array
     */
    private function getEpisode($anime, $anime_id): array
    {
        $format_id = $this->faker->numberBetween(1, 3);

        $voice_id = $this->faker->numberBetween(1,2);

        $date = $this->faker->dateTimeBetween($anime['created_at'])->format('Y-m-d H:i:s');

        $episode = [
            "anime_id" => $anime_id,
            "voice_id" => $voice_id,
            "format_id" => $format_id,
            "season" => $this->faker->numberBetween(1, 1),
            "episode" => $this->faker->numberBetween(1, 24),
            "video" => $this->getVideo(),
            "slug" => "",
            "created_at" => $date,
        ];

        $episode['slug'] = $this->slugify->slugify(
            $anime['slug'] .
            "-saison-" . $episode['season']  .
            "-" . $this->getFormat($format_id) . "-" . $episode['episode'] .
            "-" . $this->getVoice($voice_id)
        );

        return $episode;
    }

    /**
     * Pour le slug de l'épisode
     * @return string
     */
    private function getFormat($id)
    {
        $format = ["", "Episode","Film","OAV","Spécial","Chapitre","Opening","Ending","PV"];
        return $format[$id];
    }

    /**
     * Pour le slug de l'épisode
     * @return string
     */
    private function getVoice($id)
    {
        $voice = ["", "Vostfr", "VF"];
        return $voice[$id];
    }

    /**
     * Retourne 1 à 5 vidéos
     * @return string
     */
    private function getVideo(): String {
        $max = $this->faker->numberBetween(1, 5);
        $urls = "";
        for ($i=1; $i <= $max; $i++) { 
            $urls .= $this->faker->youtubeUri();
            if($i !== $max) {
                $urls .= ", ";
            }
        }
        return $urls;
    }

    private function getPdo()
    {
        try
        {
            $pdo = new PDO("mysql:host=localhost;dbname=symfony_jaken;","root","", [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ]);
    
            $pdo->exec("SET CHARACTER SET utf8");
            return $pdo;
        }
        catch (Exception $e)
        {
            die('Erreur : ' . $e->getMessage());
        }
    }
}