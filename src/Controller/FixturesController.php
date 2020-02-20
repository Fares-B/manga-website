<?php

namespace App\Controller;

use App\DataFixtures\FixturesAnimesEpisodes;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class FixturesController extends AbstractController
{
    /**
     * Function for dev | add fixtures in db
     * @Route("/fixtures", name="load_fixtures")
     */
    public function loadFixtures()
    {
        // ajoute 3 animes avec plusieurs episodes
        $fixtures = new FixturesAnimesEpisodes();
        $fixtures->generate();
        return $this->redirectToRoute('home');
    }
}