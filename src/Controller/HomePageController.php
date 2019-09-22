<?php

namespace App\Controller;

<<<<<<< HEAD
use App\Form\Type\MyProfileType;
use App\Form\Type\UserFormType;
use App\Entity\User;
use App\Services\Database\PreferenciesDatabase;
use App\Services\Database\UserDatabase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
=======
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
>>>>>>> b3f42840ec60c8cde99ff9f245f0b22345c90c2e
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
<<<<<<< HEAD
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
=======
     * @Route("/post")
     */
    public function Post()
    {
        return $this->render('home_page/Post.html.twig',[
        'title'=>"Post",
        'post'=>['title'=>'hello','text'=>'erfergfergfrkfhererfergfergfrkfhererfergfergfrkfhererfergfergfrkfhererfergfergfrkfhererfergfergfrkfhererfergfergfrkfhererfergfergfrkfhererfergfergfrkfhererfergfergfrkfher','image'=>'https://image.shutterstock.com/image-photo/mountains-during-sunset-beautiful-natural-260nw-407021107.jpg','like'=>170,'isLiked'=>true,'data'=>'22.06.2001'],
            'autor'=>['image'=>'https://images.pexels.com/photos/67636/rose-blue-flower-rose-blooms-67636.jpeg?auto=compress&cs=tinysrgb&dpr=1&w=500','name'=>'kostya zhamoydin'],
        'follower'=>false]);
>>>>>>> b3f42840ec60c8cde99ff9f245f0b22345c90c2e
    }
}
