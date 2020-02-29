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
    public function userEdit(UserRepository $repo, PaginatorInterface $paginator, Request $request, $page = ['page' => 1])
    {
        $users = $paginator->paginate(
            $repo->findAllQuery(),
            $request->query->getInt('page', $page['page']), /*numero de la page*/
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
    public function userDelete(User $user, Request $request)
    {
        $page = $this->getPageInRequestReferer($request);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('admin_users', ['page' => $page]);
    }

    /**
     * Change le role d'un utilisateur
     * @Route("/admin/user/{id}/roles", name="admin_user_change_role")
     */
    public function changeRoles(User $user, Request $request)
    {
        $moderator = "ROLE_MODERATOR";
        // si le role moderateur existe déjà dans les roles alorse on l'efface
        if(in_array($moderator, $user->getRoles())) {
            $user->setRoles(["ROLE_USER"]);
        }
        // sinon on l'ajoute
        else {
            $user->setRoles([$moderator]);
        }

        // enregistrement dans la bdd
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $page = $this->getPageInRequestReferer($request);

        return $this->redirectToRoute('admin_users', ['page' => $page]);
    }

    /**
     * Récupére l'id de la page referer
     */
    private function getPageInRequestReferer($request): int
    {
        $referer = filter_var($request->headers->get('referer'), FILTER_SANITIZE_URL);

        parse_str(parse_url($referer, PHP_URL_QUERY), $queries);

        if(isset($queries['page'])) {
            return (int)$queries['page'];
        }
        return 1;
    }
}
