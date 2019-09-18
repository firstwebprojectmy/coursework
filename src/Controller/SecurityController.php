<?php

namespace App\Controller;

use App\Form\Type\ChangePasswordType;
use App\Form\Type\ChangingPasswordType;
use App\Repository\UserRepository;
use App\Services\Database\UserDatabase;
use App\Services\Email\ChangePaswordEmail;
use App\Services\Exception\NullableConfirmeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //    $this->redirectToRoute('target_path');
        // }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/changePassword/", name="app_change_password")
     */

    public function changePassword(Request $request, ChangePaswordEmail $mailer, UserDatabase $database, UserRepository $repository)
    {
        $form = $this->createForm(ChangePasswordType::class);
        $form->handleRequest($request);

        $email = ($form->getData())['Email'];
        $isPerfect = false;

        if ($form->isSubmitted() && $form->isValid() && $database->isValidEmail($email) ){
            $user = $repository->findUserByEmail($email);
            $mailer->sendEmail($user);
            $isPerfect = true;
        }
        $error = null;
        if ($form->isSubmitted() && !$database->isValidEmail($email)){
            $error = 'Incorrect email';
        }

        return $this->render('security/changePassword.html.twig',[
            'form' => $form->createView(),
            'error' => $error,
            'isPerfect' =>$isPerfect

        ]);
    }
    /**
     * @Route("/changePassword/{slug}", name="app_changing_password")
     */
    public function changingPassword(Request $request, $slug, UserPasswordEncoderInterface $passwordEncoder, UserDatabase $userDatabase)
    {
        $form = $this->createForm(ChangingPasswordType::class);
        $form->handleRequest($request);

        $firstPassword = ($form->getData())['Password'];
        $secondPassword = ($form->getData())['Confirme-Password'];
        $isPerfect = false;

        if ($form->isSubmitted() && $form->isValid() && $firstPassword === $secondPassword){
            try{
                $user = $userDatabase->comfirmeUser($slug);
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $firstPassword
                    )
                );
                $userDatabase->changeUserPassword($user);
                $isPerfect = true;
            }catch (NullableConfirmeException $thisException){}
        }
        $error = null;
        if (!empty($thisException)){
            $error = (string)$thisException;
        }
        return $this->render('security/successCheckPassword.html.twig',[
            'form' =>$form->createView(),
            'error' => $error,
            'isPerfect' => $isPerfect
        ]);
    }



    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('/login');
    }
}
