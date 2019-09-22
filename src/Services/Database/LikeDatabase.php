<?php


namespace App\Services\Database;


use App\Entity\Like;
use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class LikeDatabase
{
    protected $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getNumberOfLikes(Post $post):int
    {
        if ($post == null){
            return 0;
        }
        return count($post->getPostLikes());
    }

    public function addNewUserLike(User $user, Post $post)
    {
        $userLike = new Like($user, $post);
        $post->addPostLike($userLike);
        $this->entityManager->persist($userLike);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function deleteUserLike(User $user, Post $post)
    {
        $repository = $this->entityManager->getRepository(Like::class);
        $userLike = $repository->findBy(
          ['user' => $user],
          ['posr' => $post]
        );
        if ($userLike != null){
            $this->entityManager->remove($userLike);
            $this->entityManager->flush();
        }
    }

    public function isUserLike(User $user, Post $post):bool
    {
        $repository = $this->entityManager->getRepository(Like::class);

        return true;
    }


}