<?php

namespace App\Controller\Comment;

use App\Entity\Comment\Comment;
// use App\Form\Comment\CommentType;
// use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * API Comment
 * @Route("/anime/comment")
 */
class CommentController extends AbstractController
{
    /**
     * Ajouter et Editer un commentaire
     * @Route("/add", name="add_comment")
     * @Route("/{id}/edit", name="edit_comment")
     */
    public function editComment(Comment $comment = null /*, Request $request,  ?UserInterface $user */)
    {
        if(!$comment) {
            $comment = new Comment();
            $animeSlug = "bleach";
        }
        // temporaire
        else {
            $animeSlug = $comment->getAnime()->getSlug();
        }

        
        // $form = $this->createForm(CommentType::class, $comment);

        // $form->handleRequest($request);

        // if ($form->isSubmitted() && $form->isValid()) {
        //     // Si l'utilisateur est connecté
        //     if($user) {
        //         $comment->setUser($user);
                // $comment->setAnime($anime);
                // // si c'est en mode edit
                // if($comment->getId()) {
                //     $comment->setUpdatedAt(new \DateTime);
                // }   
        //         $entityManager = $this->getDoctrine()->getManager();
        //         $entityManager->persist($comment);
        //         $entityManager->flush();
        //     }
        // }

        // ajouter un champ updatedAt pour la table comment et update se champ quand on edit

        return $this->redirectToRoute("anime_show", [
            'slug' => $animeSlug,
        ]);
        // return $this->render('comment/comment/index.html.twig', [
        //     'controller_name' => 'CommentController',
        // ]);
    }

    /**
     * supprimer
     * @Route("/{id}/delete", name="delete_comment")
     */
    public function deleteComment(Comment $comment, ?UserInterface $user)
    {
        $animeSlug = $comment->getAnime()->getSlug();

        if($comment->isAuthorizedEdit($user)) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();
        }

        return $this->redirectToRoute('anime_show', ['slug' => $animeSlug]);
    }
}
