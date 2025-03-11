<?php
// src/Controller/ResetPasswordController.php

namespace App\Controller;

use App\Form\ResetPasswordRequestFormType;
use App\Repository\UserRepository;
use App\Service\JWTService;
use App\Service\SendEmailService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ResetPasswordController extends AbstractController
{
    #[Route('/mot-de-passe-oublie', name: 'reset_password_request')]
public function request(Request $request, UserRepository $userRepository, JWTService $jwt, SendEmailService $mail): Response
{
    $form = $this->createForm(ResetPasswordRequestFormType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $user = $userRepository->findOneByEmail($form->get('email')->getData());

        if ($user) {
            // Générer un token JWT pour la réinitialisation
            $header = ['typ' => 'JWT', 'alg' => 'HS256'];
            $payload = ['user_id' => $user->getId()];
            $token = $jwt->generate($header, $payload);

            // Générer l'URL vers la page de réinitialisation
            $url = $this->generateUrl('reset_password', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

            // Envoyer l'email avec le lien de réinitialisation
            $mail->send(
                'no-reply@openblog.com', // Expéditeur
                $user->getEmail(), // Destinataire
                'Récupération de mot de passe sur le site OpenBlog', // Sujet
                'password_reset', // Template
                compact('user', 'url') // Variables
            );

            // Ajouter un message flash et rediriger
            $this->addFlash('success', 'Un lien de réinitialisation a été envoyé à votre adresse email.');
            return $this->redirectToRoute('app_login');
        } else {
            $this->addFlash('danger', 'Aucun utilisateur trouvé avec cet email.');
            return $this->redirectToRoute('app_login');
        }
    }

    return $this->render('security/reset_password_request.html.twig', [
        'form' => $form->createView(),
    ]);
}

    #[Route('/mot-de-passe-oublie/{token}', name: 'reset_password')]
    public function resetPassword(string $token): Response
    {
        // Ici, tu devras valider le token et permettre à l'utilisateur de réinitialiser son mot de passe

        // Pour l'exemple, on va simplement afficher le token reçu
        return $this->render('security/reset_password.html.twig', [
            'token' => $token,
        ]);
    }
}

