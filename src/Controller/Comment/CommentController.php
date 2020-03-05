<?php

namespace App\Controller\Comment;

use App\Entity\Comment\Comment;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function editComment()
    {
        // A FAIRE !!!
        return $this->render('comment/comment/index.html.twig', [
            'controller_name' => 'CommentController',
        ]);
    }

    /**
     * supprimer
     * @Route("/{id}/delete", name="delete_comment")
     */
    public function deleteComment(Comment $comment)
    {
        return [];
    }
}
