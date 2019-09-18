<?php


namespace App\Services\Email;


use App\Entity\User;
use Symfony\Component\Templating\EngineInterface;

class ConfirmeEmail extends AbstractEmail
{
    protected function getTitle(): string
    {
        return "Confirme registration!";
    }

    protected function getTwigFile(User $user): string
    {
        return 'emails/confirme.html.twig';
    }

    protected function getURL(User $user): string
    {
        return 'http://coursework.com/registration/confirme/'.$user->getConfirmeHash();
    }
    public function sendEmail(User $user)
    {
        parent::sendEmail($user);
    }

}