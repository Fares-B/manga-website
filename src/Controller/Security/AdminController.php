<?php

namespace App\Controller\Security;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="security_admin")
     */
    public function index()
    {
        return $this->render('security/admin/index.html.twig', [
            'title' => 'Administration Panel',
        ]);
    }
}
