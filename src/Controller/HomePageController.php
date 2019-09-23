<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\Type\CreatePostType;
use App\Form\Type\MyProfileType;
use App\Form\Type\UserFormType;
use App\Entity\User;
use App\Services\Database\LikeDatabase;
use App\Services\Database\PostDatabase;
use App\Services\Database\PreferenciesDatabase;
use App\Services\Database\UserDatabase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class HomePageController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(Request $request)
    {

        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'title' => 'All posts',
        ]);
    }

    /**
     * @Route("/popular")
     */
    public function popular(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM AcmeMainBundle:Article a";
        $query = $em->createQuery($dql);// переменная должна содержать массив массивов с постами
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'title' => 'Popular',
            'posts' => $this->get('knp_paginator')->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), 10)
        ]);
    }

    /**
     * @Route("/myprofile", name="app_profile")
     */

    public function myProfile(Request $request,AuthenticationUtils $authenticationUtils, UserDatabase $userDatabase, PreferenciesDatabase $preferenciesDatabase)
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        /**
         * @var User $user
         */
        $user = $this->getUser();
        $userPreferences = $preferenciesDatabase->getUserPrefencies($user);

        $form = $this->createForm(MyProfileType::class, $user, [
            'firstName' => $user->getFirstName(),
            'secondName' => $user->getSecondName(),
            'shortInformation' => $user->getShortInformation()
        ]);
        $form->setData($user);
        $form->handleRequest($request);
        $isSaved = false;
        if ($form->isSubmitted() && $form->isValid()) {
            $userDatabase->updateUser($user);
            $isSaved = true;
        }
        return $this->render('home_page/myprofile.html.twig', [
            'form' => $form->createView(),
            'isSaved' => $isSaved,
            'userPreferences' => $userPreferences
        ]);
    }

    /**
     * @Route("/blogger/{bloggerID}", name="app_blogger")
     */
    public function bloggerProfile(Request $request,UserDatabase $userDatabase, PostDatabase $postDatabase, string $bloggerID)
    {
        $blogger = $userDatabase->getBlogger($bloggerID);
        $bloggerPosts = $postDatabase->getUserPost($blogger);
        return $this->render('home_page/bloggerprofile.html.twig',[
           'blogger' => $blogger,
            'posts' => $this->get('knp_paginator')->paginate(
                $bloggerPosts, /* query NOT result */
                $request->query->getInt('page', 1), 10),
            'title' => 'Blogger page',
        ]);
    }


    /**
     * @Route("/post/{postID}")
     */
    public function Post(Request $request, int $postID, PostDatabase $postDatabase,  LikeDatabase $likeDatabase, PreferenciesDatabase $preferenciesDatabase)
    {
        $post = $postDatabase->findPostByID($postID);
        $likes = $likeDatabase->getNumberOfLikes($post);
        echo 1;
        $userLike = false;
        $userPreference = false;
        if ($this->getUser()){
            $userLike = $likeDatabase->isUserLike($this->getUser(), $post);
            $userPreference = $preferenciesDatabase->isUserPreference($this->getUser(), $post->getUser());
        }
        return $this->render('home_page/Post.html.twig',[
            'title'=>'Post',
            'post' => $post,
            'likes' => $likes,
            'userLike' => $userLike,
            'autor' => $post->getUser(),
            'follow' => $userPreference,
        ]);
    }

    /**
     * @Route("/createPost")
     */
    public function createPost(Request $request, PostDatabase $postDatabase)
    {
        $post = new Post();
        $form = $this->createForm(CreatePostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $postDatabase->addNewPost($this->getUser(), $post);
            return $this->redirectToRoute("home_page");
        }

        return $this->render("home_page/createpost.html.twig",[
            'title' => 'Create Post!',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/myPosts")
     */
    /*public function myPost(PostDatabase $postDatabase)
    {

    } */


}
