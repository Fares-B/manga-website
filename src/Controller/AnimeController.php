<?php

namespace App\Controller;

use App\Form\AnimeType;
use App\Entity\Anime\Anime;
use App\Repository\Anime\AnimeRepository;
use App\Form\SearchAnimeType;

use Cocur\Slugify\Slugify;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



class AnimeController extends AbstractController
{
    /**
     * Affiche une liste de tous les animés
     * 
     * @Route("/anime", name="anime")
     */
    public function anime(AnimeRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $searchForm = $this->createForm(SearchAnimeType::class);

        $searchForm->handleRequest($request);

        
        // si j'ai des criteres de recherche alors on like sinon on affiche la liste complète
        if ($searchForm->isSubmitted() && $searchForm->isValid()) {
            $criteria = $searchForm->getData();
            $query = $repo->likeAnime($criteria);
        }
        else {
            $query = $repo->findAllQuery();
        }

        $animes = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1), /*page number*/
            20 // limit per page
        );

        // $animes = $repo->findAll();
        return $this->render('anime/anime.html.twig', [
            'title' => 'Anime Liste',
            'formSearch' => $searchForm->createView(),
            'animes' => $animes
        ]);
    }

    /**
     * Formulaire pour créer un nouveau animé
     * 
     * @Route("/anime/new", name="anime_create")
     * @Route("/anime/{slug}/edit", name="anime_edit")
     */
    public function formAnime(Anime $anime = null, Request $request)
    {
        if (!$anime) {
            $anime = new Anime();
        }

        $form = $this->createForm(AnimeType::class, $anime);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!$anime->getId()) {
                $slugify = new Slugify();

                $anime->setCreatedAt(new \DateTime);
                $anime->setSlug($slugify->slugify($anime->getTitle()));
            }

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($anime);

            $entityManager->flush();

            return $this->redirectToRoute('anime_show', ['slug' => $anime->getSlug()]);
        }

        return $this->render('anime/form_anime.html.twig', [
            'title' => $anime->getTitle(),
            'formAnime' => $form->createView(),
            'editMode' => $anime->getId() === null
        ]);
    }

    /**
     * Affiche la page de presentation d'un animé
     * 
     * @Route("/anime/{slug}", name="anime_show")
     */
    public function showAnime(Anime $anime) //param converter
    {
        return $this->render('anime/show_anime.html.twig', [
            'anime' => $anime // send 1 anime
        ]);
    }
}
