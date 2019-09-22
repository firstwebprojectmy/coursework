<?php


namespace App\Services\Database;


use App\Entity\Preferences;
use App\Entity\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class PreferenciesDatabase
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $em)
    {
        $this->entityManager = $em;
    }

    public function getUserPrefencies(User $user)
    {
        $preferencies = $user->getPreferences();
        $collection = array();
        foreach ($preferencies as $preferency){
            array_push($collection,$preferency->getBlogger());
        }
        return $collection;

    }
    public function addUserPrefencies(User $user, int $bloggerID)
    {
        /**
         * @var User $blogger
         */
        $repository = $this->entityManager->getRepository(User::class);
        $blogger =$repository->find($bloggerID);
        $preferency = new Preferences($user,$blogger);
        $user->addPreference($preferency);
        $this->entityManager->persist($preferency);
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
    public function deletePrefencies(User $user, User $blogger)
    {
        $repository = $this->entityManager->getRepository(User::class);
        $preference = $repository->findBy(
            ['user' => $user],
            ['blogger' => $blogger]
        );
        $this->entityManager->remove($preference);
        $this->entityManager->flush();

    }

}