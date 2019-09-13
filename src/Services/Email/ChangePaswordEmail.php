<?php


namespace App\Services\Email;


use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Templating\EngineInterface;

class ChangePaswordEmail extends AbstractEmail
{



    public function sendEmail(User $user)
    {
        parent::sendEmail($user);
    }

    protected function getTitle(): string
    {
        return "Change password!";
    }

    protected function getTwigFile(User $user): string
    {
        return 'emails/changePassword.html.twig';
    }

    protected function getURL(User $user): string
    {
        return 'http://corsework.com/changepassword/'.$user->getConfirmeHash();
    }

}