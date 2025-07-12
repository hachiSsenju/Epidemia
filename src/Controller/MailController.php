<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;


final class MailController extends AbstractController
{
    #[Route('/test-mail', name: 'test_mail')]
    public function sendMail(MailerInterface $mailer)
    {
        $email = (new Email())
        ->from('hachisenju49@gmail.com')
            ->to('mahdibihan227@gmail.com')
            ->subject('Test Email')
            ->text('This is a plain text email body.')
            ->html('<p>This is an <strong>HTML</strong> email body.</p>');

       try {
    $mailer->send($email);
} catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
    // log or handle error
}

        return $this->json(['message' => 'Email sent!', 'status' => 'success','email' => $email->getTo()[0]->getAddress(),'content' => $email->getHtmlBody(),"receiver" => $email->getFrom()[0]->getAddress()]);
    }
}
