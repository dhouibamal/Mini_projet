<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: "/connexion", name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
       // Vérifier si l'utilisateur est déjà connecté
    if ($this->getUser()) {
        // Si oui, rediriger vers la page admin
        return $this->redirectToRoute('app_admin');
    }

    // Récupérer l'erreur si elle existe
    $error = $authenticationUtils->getLastAuthenticationError();
    // Dernier username saisi
    $lastUsername = $authenticationUtils->getLastUsername();

    // Retourner la page de connexion
    return $this->render('security/login.html.twig', [
        'last_username' => $lastUsername,
        'error' => $error,
    ]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Cette méthode est interceptée par Symfony
        throw new \LogicException('Cette méthode peut être vide - elle sera interceptée par la clé de logout sur votre firewall.');
    }
}
