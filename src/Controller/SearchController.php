<?php

namespace App\Controller;

use App\Repository\Anime\AnimeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SearchController extends AbstractController
{
    /**
     * Ce controller sera utile quand j'utiliserai des requetes ajax sous javascript
     * @return json
     */
    public function searchAnime(Request $request, AnimeRepository $AnimeRepository)
    {
        return "json";
    }
}