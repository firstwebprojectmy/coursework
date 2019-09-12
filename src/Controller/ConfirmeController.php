<?php


namespace App\Controller;


use App\Services\Database\UserDatabase;
use App\Services\Exception\NullableUserException;
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
    public function confirmeUser(UserDatabase $userDatabase, string $slug)
    {
        try{
            $userDatabase->comfirmeUser($slug);
        }catch (NullableUserException $thisException){}

        return $this->render('registration/successConfirmePassword.html.twig',[
            'error' => (string)$thisException
        ]);
    }

}