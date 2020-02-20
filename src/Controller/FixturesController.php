<?php

namespace App\Controller;

use App\DataFixtures\FixturesAnimesEpisodes;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FixturesController extends AbstractController
{
    /**
     * Ajoute du contenu fictif
     * Fonction pour dév
     * 
     * @Route("/fixtures", name="load_fixtures")
     */
    public function loadFixtures()
    {
        // FixturesAnimesEpisodes($numberOfAnime)
        $fixtures = new FixturesAnimesEpisodes(3); // => Ajoute 3 animes et 11 à 26 episodes par anime.
        $fixtures->generate();
        return $this->redirectToRoute('home');
    }
}