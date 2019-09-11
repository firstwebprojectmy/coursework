<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class UserProcessing
{
    protected $entityManager;
    protected $mailer;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    public function userInitialization(User $user)
    {
        $user->setConfirmeHash($this->createConfirmeHash($user->getEmail()));
        $user->setIsConfirmed(false);
        $user->setIsBanned(false);
        if ($user->getIsBlogger()){
            $user->setIsComfirmedByModerator(false);
        }
        $user->setRegisretedAt(new \DateTime());

        $this->addToDatabase($user);
    }

    public function createConfirmeHash(string $emailAddress)
    {
        return md5($emailAddress . date(DATE_RFC2822));
    }

    private function addToDatabase(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }






}