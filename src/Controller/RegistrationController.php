<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserFormType;
use App\Services\Database\UserDatabase;
use App\Services\Email\ConfirmeByModeratorEmail;
use App\Services\Email\ConfirmeEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function register(Request $request, UserDatabase $userDatabase,UserPasswordEncoderInterface $passwordEncoder, ConfirmeEmail $userMailer)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $userDatabase->addToDatabase($user);
            $userMailer->sendEmail($user);
            return $this->redirectToRoute('app_confirme');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
