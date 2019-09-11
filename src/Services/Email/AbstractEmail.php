<?php


namespace App\Services\Email;


use App\Entity\User;
use Symfony\Component\Templating\EngineInterface;

abstract class AbstractEmail
{
    private $templating;
    private $mailer;

    protected function sendEmail(User $user)
    {
        $title = $this->getTitle();
        $email = $user->getEmail();
        $URL = $this->getURL($user);
        $twigFile = $this->getTwigFile($user);
        $this->mailer->send($this->createMessage($title, $email, $twigFile, $URL));
    }

    public function __construct(\Swift_Mailer $mailer, EngineInterface $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    private function createMessage(string $title, string $email, string $twigFile, string $URL):\Swift_Message
    {
        $message = (new \Swift_Message($title))
            ->setFrom('send@example.com')
            ->setTo($email)
            ->setBody(
                $this->templating->render(
                    $twigFile,
                    ['URL' => $URL]
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