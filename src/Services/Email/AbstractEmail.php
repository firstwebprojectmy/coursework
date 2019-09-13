<?php


namespace App\Services\Email;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Services\Database\UserDatabase;
use Doctrine\ORM\EntityManagerInterface;


abstract class AbstractEmail
{
    private $templating;
    private $mailer;
    protected $userRepository;

    protected function sendEmail(User $user)
    {
        $this->mailer->send($this->createMessage($user));
    }

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $templating, UserRepository $repository)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->userRepository = $repository;
    }

    private function createMessage(User $user):\Swift_Message
    {
        $message = (new \Swift_Message($this->getTitle()))
            ->setFrom('send@example.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->templating->render(
                    $this->getTwigFile($user), [
                        'URL' => $this->getURL($user),
                        'name' => $user->getFirstName()." ".$user->getSecondName()
                    ]
                ),
                'text/html'
            )
        ;
        return $message;
    }

    abstract protected function getTitle():string;
    abstract protected function getTwigFile(User $user):string;
    abstract protected function getURL(User $user):string;




}