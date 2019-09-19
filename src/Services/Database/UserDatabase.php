<?php


namespace App\Services\Database;


use App\Entity\User;
use App\Services\Exception\NullableConfirmeException;
use Doctrine\ORM\EntityManagerInterface;

class UserDatabase
{
    protected $entityManager;
    protected $metadata;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function addToDatabase(User $user)
    {
        $this->initUser($user);
        $this->addNewUser($user);
    }

    public function updateUser(User $user)
    {
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

    public function comfirmeUser(string $confirmeHash):User
    {
        $repository = $this->entityManager->getRepository(User::class);
        /**
         * @var User $user
         */
        $user = $repository->findOneBy([
            'confirmeHash' => $confirmeHash
        ]);
        if ($user == null){
            throw new NullableConfirmeException();
        }
        $user->setConfirmeHash($this->createConfirmeHash($user->getEmail()));
        $user->setIsConfirmed(true);
        $this->entityManager->flush();
        return $user;
    }

    public function isValidEmail(string $email):bool
    {
        $repository = $this->entityManager->getRepository(User::class);
        $user = $repository->findOneBy([
            'email' => $email
        ]);
        if (!$user){
            return false;
        }
        return true;
    }
    public function changeUserPassword(User $user)
    {
        $user->setConfirmeHash($this->createConfirmeHash($user->getEmail()));
        $this->addNewUser($user);
    }

}