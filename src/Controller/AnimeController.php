<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Anime;
use App\Entity\Episode;
use App\Repository\AnimeRepository;
use App\Repository\EpisodeRepository;
use App\Form\AnimeType;
use App\Form\EpisodeType;

use Cocur\Slugify\Slugify;

class AnimeController extends AbstractController
{
    
    /**
     * @Route("/", name="home")
     */
    public function home(EpisodeRepository $repo)
    {
        $episodes = $repo->findAll();
        return $this->render('anime/home.html.twig', [
            'title' => 'Jaken Anime',
            'episodes' => $episodes
        ]);
    }

    /**
     * @Route("/anime", name="anime")
     */
    public function anime(AnimeRepository $repo)
    {
        $animes = $repo->findAll();
        return $this->render('anime/anime.html.twig', [
            'title' => 'Anime Liste',
            'animes' => $animes // send all animes in database
        ]);
    }

    /**
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

        // dump($anime);
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
     * @Route("/anime/episode/new", name="episode_create")
     * @Route("/anime/episode/{slug}/edit", name="episode_edit")
     */
    public function formEpisode(Episode $episode = null, Request $request)
    {
        if (!$episode) {
            $episode = new Episode();
        }
        
        $form = $this->createForm(EpisodeType::class, $episode);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$episode->getId()) {
                $episode->setCreatedAt(new \DateTime);
                $url_slug = "anime->getTitle()" + "saison";
                $anime->setSlug($slugify->slugify($url_slug));
            }
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($episode);

            $entityManager->flush();

            return $this->redirectToRoute('episode_show', ['slug' => $episode->getSlug()]);
        }
        return $this->render('anime/form_episode.html.twig', [
            'formEpisode' => $form->createView(),
            'editMode' => $episode->getId() === null
        ]);
    }

    /**
     * @Route("/anime/{slug}", name="anime_show")
     */
    public function showAnime(Anime $anime) //param converter
    {
        return $this->render('anime/show_anime.html.twig', [
            'anime' => $anime // send 1 anime
        ]);
    }

    /**
     * @Route("/show/{slug}", name="episode_show")
     */
    public function showEpisode(Episode $episode)
    {
        return $this->render('anime/show_episode.html.twig', [
            'episode' => $episode
        ]);
    }
}
