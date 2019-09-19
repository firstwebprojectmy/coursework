<?php

namespace App\Controller;

use App\Form\Type\MyProfileType;
use App\Form\Type\UserFormType;
use App\Entity\User;
use App\Services\Database\PreferenciesDatabase;
use App\Services\Database\UserDatabase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class HomePageController extends AbstractController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index()
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'title' => 'All posts'
        ]);
    }

    /**
     * @Route("/popular")
     */
    public function popular()
    {
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'title' => 'Popular'
        ]);
    }

    /**
     * @Route("/myprofile", name="app_profile")
     */

    public function myProfile(Request $request,AuthenticationUtils $authenticationUtils, UserDatabase $userDatabase, PreferenciesDatabase $preferenciesDatabase)
    {
        if (!$this->getUser()){
            return $this->redirectToRoute('app_login');
        }
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $userPreferences = $preferenciesDatabase->getUserPrefencies($user);

        $form = $this->createForm(MyProfileType::class,$user,[
            'firstName' => $user->getFirstName(),
            'secondName' => $user->getSecondName(),
            'shortInformation' => $user->getShortInformation()
        ]);
        $form->setData($user);
        $form->handleRequest($request);
        $isSaved = false;
        if ($form->isSubmitted() && $form->isValid()){
            $userDatabase->updateUser($user);
            $isSaved = true;
        }
        return $this->render('home_page/myprofile.html.twig',[
            'form' => $form->createView(),
            'isSaved' => $isSaved,
            'userPreferences' => $userPreferences
        ]);
    }
}
