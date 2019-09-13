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
        $moderators = $this->userRepository->findUsersByRole("ROLE_MODERATOR");
        var_dump($moderators);
        /**
         * @var User $moderator
         */
        foreach ($moderators as $moderator){
            $user->setEmail($moderator->getEmail());
            parent::sendEmail($user);
        }
    }
}