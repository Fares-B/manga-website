<?php

namespace App\Controller;

use App\Repository\Episode\EpisodeRepository;

use Knp\Component\Pager\PaginatorInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Affiche la page d'accueil
     * 
     * @Route("/", name="home")
     */
    public function home(EpisodeRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $episodes = $paginator->paginate(
            $repo->findAllQuery(),
            $request->query->getInt('page', 1), /*page number*/
            20 // limit per page
        );

        // $episodes = $repo->findAll();
        return $this->render('home/home.html.twig', [
            'title' => 'Jaken Anime',
            'episodes' => $episodes,
        ]);
    }
}
