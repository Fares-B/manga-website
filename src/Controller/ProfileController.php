<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
 * @Route("/profile")
 */
class ProfileController extends AbstractController
{
    /**
     * @Route("/{username}", name="user_profile")
     */
    public function userProfile(User $user)
    {
        return $this->render('profile/user_profile.html.twig', [
            'user' => $user,
        ]);
    }
}
