<?php


namespace App\Services\Email;


use App\Entity\User;

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
        return 'http://corsework/confirme/'.$user->getConfirmeHash();
    }

}