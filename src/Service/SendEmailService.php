<?php
// src/Service/SendEmailService.php
namespace App\Service;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

class SendEmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $from, string $to, string $subject, string $template, array $parameters = []): void
    {
        // Création du message
        $email = (new Email())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->html($template);  // Assurez-vous que le template est généré comme du HTML ou ajustez-le

        // Envoi de l'email
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            // Gérer l'exception si l'email n'a pas pu être envoyé
            throw new \Exception("E-mail non envoyé: " . $e->getMessage());
        }
    }
}
