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
        return 'http://corsework.com/bloggers/'.$user->getId();
    }
    public function sendEmail(User $user)
    {
        $repository = $this->entityManager->getRepository(User::class);
        $moderators = $repository->findBy(
          ['roles' => 'ROLE_MODERATOR']
        );
        foreach ($moderators as $moderator){
            parent::sendEmail($moderator);
        }
    }
}