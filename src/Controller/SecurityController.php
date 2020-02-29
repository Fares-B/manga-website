<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Security\LoginType;
use App\Form\Security\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    /**
     * Inscription
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $user->setRoles($user->getRoles());

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);

            $entityManager->flush();

            return $this->redirectToRoute("security_login");
        }
        return $this->render('security/registration.html.twig', [
            'title' => 'Inscription',
            'form' => $form->createView(),
        ]);
    }

    /**
     * Connexion
     * @Route("/login", name="security_login")
     */
    public function login(Request $request)
    {
        return $this->render('security/login.html.twig', [
            'title' => 'Connexion',
        ]);
    }
}
