<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;


class HomePageController extends Controller
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM AcmeMainBundle:Article a";
        $query = $em->createQuery($dql);// переменная должна содержать массив массивов с постами
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
}
