<?php

namespace App\Controller;

use App\Repository\Anime\AnimeRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * Retourne Du JSON, utiliser avec des requetes ajax (barre de recherche du site)
     * methode => POST
     * @Route("/api/search/anime", name="api_search_anime")
     * @return Response
     */
    public function searchAnime(Request $request, AnimeRepository $repo)
    {
        $title = $request->request->get('title');
        $result = $repo->findAnimeTitle($title);
        $jsonResult = new JsonResponse($result);
        return $jsonResult;
    }
}