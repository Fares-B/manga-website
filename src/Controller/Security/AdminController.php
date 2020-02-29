<?php

namespace App\Controller\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_panel")
     */
    public function index()
    {
        return $this->render('security/admin/index.html.twig', [
            'title' => 'Administration Panel',
        ]);
    }

    /**
     * @Route("/admin/user", name="admin_users")
     */
    public function userEdit(UserRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $users = $paginator->paginate(
            $repo->findAllQuery(),
            $request->query->getInt('page', 1), /*numero de la page*/
            10 // limit par page
        );

        return $this->render('security/admin/user.html.twig', [
            'title' => 'Administration utilisateur',
            'users' => $users,
        ]);
    }

    /**
     * Supprime un utilisateur ou moderateur
     * @Route("/admin/user/{id}/delete", name="admin_user_delete")
     */
    public function userDelete(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin_users');
    }
}
