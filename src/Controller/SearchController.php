<?php

namespace App\Controller;

use App\Repository\Anime\AnimeRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Api search anime
 */
class SearchController extends AbstractController
{
    private $animeRepo;

    public function __construct(AnimeRepository $animeRepo) {
        $this->animeRepo = $animeRepo;
    }
    /**
     * Retourne Du JSON, utiliser avec des requetes ajax (barre de recherche du site)
     * methode => POST
     * @Route("/api/search/anime/title", name="api_search_anime_title")
     * @return Response
     */
    public function searchAnimeTitle(Request $request)
    {
        $title = $request->query->get("title");
        $result = $this->animeRepo->findAnimeTitle($title);
        return new JsonResponse($result);
    }

    /**
     * @Route("/api/search/anime/criteria", name="api_search_anime_criteria", methods={"GET"})
     * @return Response
     */
    public function searchAnimeCriteria(Request $request)
    {
        $criteria = $request->query->all();
        $result = $this->animeRepo->searchAnime($criteria)->getResult();
        return $this->json($result, 200, [], ['groups' => 'api_anime_search']);
    }
}