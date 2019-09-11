<?php


namespace App\Services\Email;


use App\Entity\User;

class ConfirmeByModeratorEmail extends AbstractEmail
{
    protected function getTitle(): string
    {
        return "Confirme new blogger!";
    }

    protected function getTwigFile(User $user): string
    {
        return 'emails/confirmeByModerator.html.twig';
    }

    protected function getURL(User $user): string
    {
        return 'http://corsework/bloggers/'.$user->getId();
    }

}