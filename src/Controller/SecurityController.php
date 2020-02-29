<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Security\LoginType;
use App\Form\Security\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SecurityController extends AbstractController
{
    /**
     * Inscription
     * @Route("/registration", name="security_registration")
     */
    public function registration(Request $request)
    {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setRoles($user->getRoles());

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);

            $entityManager->flush();
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
        $user = new User();
        $form = $this->createForm(LoginType::class, $user);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($user);
        }

        return $this->render('security/login.html.twig', [
            'title' => 'Connexion',
            'form' => $form->createView(),
        ]);
    }
}