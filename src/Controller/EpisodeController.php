<?php

namespace App\Controller;

use App\Entity\Anime\Anime;
use App\Entity\Episode\Episode;
use App\Form\EpisodeType;

use Cocur\Slugify\Slugify;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EpisodeController extends AbstractController
{
    /**
     * Formulaire pour ajouter/editer un episode
     * 
     * 1er route pour l'ajout d'un episode depuis une page d'anime
     * 2eme route creation d'un episode
     * 3eme editer un episode
     * 
     * @Route("/anime/episode/new?{id}", name="episode_create")
     * @Route("/anime/episode/new", name="episode_create")
     * @Route("/anime/episode/{slug}/edit", name="episode_edit")
     */
    public function formEpisode(Episode $episode = null, Request $request)
    {
        if (!$episode) {
            $episode = new Episode();
        }

        $repo = $this->getDoctrine()->getRepository(Anime::class);

        $animes = $repo->findAll();

        $form = $this->createForm(EpisodeType::class, $episode);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$episode->getId()) {
                $episode->setCreatedAt(new \DateTime); // don't change the date
            }

            $slugify = new Slugify();

            $link = $episode->getAnime()->getTitle() . ' ' . $episode->getTitle();

            $episode->setSlug($slugify->slugify($link));

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($episode);

            $entityManager->flush();

            return $this->redirectToRoute('episode_show', ['slug' => $episode->getSlug()]);
        }
        $animeId = null;
        if (isset($_GET['id'])) {
            $animeId = (int)$_GET['id'];
        }
        return $this->render('episode/form_episode.html.twig', [
            'formEpisode' => $form->createView(),
            'episode' => $episode,
            'editMode' => $episode->getId() === null,
            'animeId' => $animeId
        ]);
    }

    /**
     * Affiche l'episode rechercher
     * 
     * @Route("/show/{slug}", name="episode_show")
     */
    public function showEpisode(Episode $episode)
    {
        return $this->render('episode/show_episode.html.twig', [
            'title' => $episode->getTitle(),
            'episode' => $episode
        ]);
    }
}
