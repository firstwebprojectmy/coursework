<?php


namespace App\Controller;


use App\Services\Database\UserDatabase;
use App\Services\Email\ConfirmeByModeratorEmail;
use App\Services\Exception\NullableConfirmeException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConfirmeController extends AbstractController
{
    /**
     * @Route("/registration/confirme", name="app_confirme")
     */
    public function confirme()
    {
        return $this->render('registration/confirmePassword.html.twig');
    }

    /**
     * @Route("/registration/confirme/{slug}", name="app_confirme_user")
     */
    public function confirmeUser(ConfirmeByModeratorEmail $moderatorEmail,UserDatabase $userDatabase, string $slug)
    {
        try{
            $user = $userDatabase->comfirmeUser($slug);
            $moderatorEmail->sendEmail($user);
            return $this->render('registration/successConfirmePassword.html.twig',[
                'error' => null
            ]);
        }catch (NullableConfirmeException $thisException){
            $error = $thisException->getMessage();
            return $this->render('registration/successConfirmePassword.html.twig',[
                'error' => $error
            ]);
        }


    }

}