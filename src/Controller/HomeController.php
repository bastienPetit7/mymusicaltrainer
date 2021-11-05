<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, MailerInterface $mailer): Response
    {
        
        $form = $this->createForm(ContactType::class); 
        $form->handleRequest($request); 

        if($form->isSubmitted() && $form->isValid())
        {

            $name = $form->get('nom')->getData(); 
            $email = $form->get('email')->getData(); 
            $message = $form->get('message')->getData();

            $contactEmail = (new TemplatedEmail())
                                ->from($email)
                                ->to('contact@bastienpetit.fr')
                                ->htmlTemplate('email/contact.html.twig')
                                ->context([
                                    'email_contact' => $email,
                                    'nom' => $name, 
                                    'message' => $message
                                ]); 
            $mailer->send($contactEmail); 

            $this->addFlash('light', 'Votre message a bien été envoyé à My Muscical Trainer');

            return new RedirectResponse('https://127.0.0.1:8000/#contact'); 

        }




        return $this->render('home/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
