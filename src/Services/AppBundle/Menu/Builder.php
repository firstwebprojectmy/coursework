<?php


namespace App\Services\AppBundle\Menu;



use Knp\Menu\FactoryInterface;
use Knp\Menu\Matcher\Matcher;
use Knp\Menu\Renderer\ListRenderer;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

class Builder implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('My Menu');
        $menu->addChild('Profile', ['uri' => '/profile']);
        $menu->addChild('All Posts', ['uri' => '/allposts']);
        $menu->addChild('Bloggers', ['uri' => '/allbloggers']);

        $renderer = new ListRenderer(new Matcher());
        echo $renderer->render($menu);
        $twigloader = new FilesystemLoader('base.html.twig');
        $twig = new Environment($twigloader);
        $twig->display('menu.twig',[
            'renderer' => $renderer,
            'menu' => $menu,
        ]);


    }
}