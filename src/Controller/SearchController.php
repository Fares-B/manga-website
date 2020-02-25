<?php

namespace App\Controller;

use App\Repository\Anime\AnimeRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        $title = $request->request->get('title');
        $result = $this->animeRepo->findAnimeTitle($title);
        return $this->getJsonResponse($result);
    }

    /**
     * @Route("/api/search/anime/criteria", name="api_search_anime_criteria")
     */
    public function searchAnimeCriteria(Request $request)
    {
        $criteria = $request->query->all();
        $result = $this->animeRepo->searchAnime($criteria);
        dd($result);
        // ne marche pas pour l'instant car le repo demande une entité avec des getter
        return $this->getJsonResponse(['ok' => 1]);
    }
    private function getJsonResponse($data)
    {
        return (new JsonResponse($data));
    }
}