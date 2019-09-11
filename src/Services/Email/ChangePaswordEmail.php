<?php


namespace App\Services\Email;


use App\Entity\User;
use Symfony\Component\Templating\EngineInterface;

class ChangePaswordEmail extends AbstractEmail
{

    protected function sendEmail(User $user)
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
        return 'http://corsework/changepassword/'.$user->getConfirmeHash();
    }

}