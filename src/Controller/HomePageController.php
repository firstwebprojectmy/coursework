<?php

namespace App\Controller;

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
        $query = [
            ['id'=>1,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>2,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>3,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>false],
            ['id'=>4,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>false],
            ['id'=>5,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>6,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>false],
            ['id'=>7,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>8,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>false],
            ['id'=>9,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>10,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>false],
            ['id'=>11,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>12,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>false],
            ['id'=>13,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>14,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
            ['id'=>15,'title'=>'first post','image'=>'','text'=>'jksvjgvhgjhvgdkhvgggfuygregrfgerjhfgerjkhgfrej','like'=>140,'data'=>'12.03.2001','isLiked'=>true],
        ];
        // $em = $this->get('doctrine.orm.entity_manager');
        // $dql = "SELECT a FROM AcmeMainBundle:Article a";
        // $query = $em->createQuery($dql);// переменная должна содержать массив массивов с постами
        return $this->render('home_page/index.html.twig', [
            'controller_name' => 'HomePageController',
            'title' => 'All posts',
            'posts' => $this->get('knp_paginator')->paginate(
                $query, /* query NOT result */
                $request->query->getInt('page', 1), 10)
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
    public function Post(Request $request, int $postID, PostDatabase $postDatabase,  LikeDatabase $likeDatabase)
    {
        $post = $postDatabase->findPostByID($postID);
        $likes = $likeDatabase->getNumberOfLikes($post);
        $userLike = false;
        if ($this->getUser()){
            $likeDatabase->
        }


        return $this->render('home_page/Post.html.twig',[
           'post' => $post

        ]);
    }
}
