<?php


namespace App\Services\Database;


use App\Entity\Post;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Common\Collections\Collection;

class PostDatabase
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }



    public function getUserPost(User $user):Collection
    {
        if ($user == null){
            return (Collection::class)();
        }
        $posts = $user->getPosts();
        return $posts;
    }

    public function deletePostbyID(int $postID)
    {
        $repository = $this->entityManager->getRepository(Post::class);
        $post = $repository->find($postID);
        $this->entityManager->remove($post);
        $this->entityManager->flush();
    }

    public function banPostByID(int $postID)
    {
        $repository = $this->entityManager->getRepository(Post::class);
        /**
         * @var Post $post
         */
        $post = $repository->find($postID);
        $post->setIsBanned(true);
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function findPostByID(int $postID):Post
    {
        $repository = $this->entityManager->getRepository(Post::class);
        /**
         * @var Post $post
         */
        $post = $repository->find($postID);
        return $post;
    }
}