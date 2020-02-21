<?php

namespace App\Controller;

use App\Form\SearchAnimeType;

use App\Repository\Anime\AnimeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * Recherche un anime dans la bdd et renvoi
     * Créer ici une api rest pour ensuite pouvoir l'utiliser avec js (ajax)
     * 
     * @Route("/search", name="anime_search")
     */
    public function searchAnime(Request $request, AnimeRepository $AnimeRepository)
    {
        $searchForm = $this->createForm(SearchAnimeType::class);
        $animes = null;
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $criteria = $searchForm->getData();
            $animes = $AnimeRepository->likeAnime($criteria);
        }
        return $this->render("search/index.html.twig", [
            'formSearch' => $searchForm->createView(),
            'animes' => $animes,
        ]);
    }
}