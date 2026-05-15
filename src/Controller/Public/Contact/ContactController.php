<?php

namespace App\Controller\Public\Contact;

use App\Form\ContactType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new TemplatedEmail())
                ->from('noreply@vite-et-gourmand.fr')
                ->to('contact@vite-et-gourmand.fr')
                ->replyTo($data['email'])
                ->subject('[Contact] ' . $data['title'])
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'contact' => $data,
                ]);

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a bien été envoyé. Nous vous répondrons dans les meilleurs délais.');
            return $this->redirectToRoute('contact');
        }

        return $this->render('public/contact/contact.html.twig', [
            'form' => $form,
        ]);
    }
}