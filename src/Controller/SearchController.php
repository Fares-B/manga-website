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
     * 
     * @Route("/search", name="anime_search")
     */
    public function searchAnime(Request $request, AnimeRepository $AnimeRepository)
    {
        $searchForm = $this->createForm(SearchAnimeType::class);
        $result = null;
        $searchForm->handleRequest($request);
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $criteria = $searchForm->getData();
            $result = $AnimeRepository->likeAnime($criteria);
        }
        return $this->render("search/index.html.twig", [
            'formSearch' => $searchForm->createView(),
            'result' => $result,
        ]);
    }
}