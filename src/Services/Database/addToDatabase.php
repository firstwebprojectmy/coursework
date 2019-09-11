<?php


namespace App\Services;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;


class addToDatabase
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function addToDatabase(User $user)
    {
        $this->initUser($user);
        $this->addNewUser($user);
    }

    public function createConfirmeHash(string $emailAddress):string
    {
        return md5($emailAddress . date(DATE_RFC2822));
    }

    private function addNewUser(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    private function initUser(User $user)
    {
        $user->setConfirmeHash($this->createConfirmeHash($user->getEmail()));
        $user->setIsConfirmed(false);
        $user->setIsBanned(false);
        if ($user->getIsBlogger()){
            $user->setIsComfirmedByModerator(false);
        }
        $user->setRegisretedAt(new \DateTime());
    }




}