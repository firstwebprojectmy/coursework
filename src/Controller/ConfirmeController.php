<?php


namespace App\Controller;


use App\Services\Database\UserDatabase;
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
        $userDatabase->comfirmeUser($slug);
        return $this->render('registration/successConfirmePassword.html.twig');
    }

}