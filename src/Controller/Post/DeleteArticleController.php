<?php

namespace App\Controller\Post;

use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class DeleteArticleController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    private PostRepository $postRepository;

    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
    }

    #[Route("/api/post/delete/{id}", name:"api_post_delete", methods: ['DELETE'] )]
    public function delete($id)
    {
        $post = $this->postRepository->findOneBy(['id' => $id]);
        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return new JsonResponse();
    }
}
