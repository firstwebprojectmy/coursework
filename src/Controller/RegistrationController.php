<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserFormType;
use App\Services\Database\UserDatabase;
use App\Services\Email\ConfirmeEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration", name="registration")
     */
    public function register(Request $request, UserDatabase $userDatabase)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $userDatabase->addToDatabase($user);


        }



        return $this->render('registration/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
