<?php


namespace App\Services\Database;


use App\Entity\User;
use App\Services\Exception\NullableUserException;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Null_;


class UserDatabase
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

    public function comfirmeUser(string $confirmeHash)
    {
        $repository = $this->entityManager->getRepository(User::class);
        /**
         * @var User $user
         */
        $user = $repository->findOneBy([
            'confirmeHash' => $confirmeHash
        ]);
        if ($user == null){
            throw new NullableUserException();
        }
        $user->setConfirmeHash($this->createConfirmeHash($user->getEmail()));
        $user->setIsConfirmed(true);
        $this->entityManager->flush();
    }



}