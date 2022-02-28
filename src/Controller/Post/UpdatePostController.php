<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class UpdatePostController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private PostRepository $postRepository;

    public function __construct(EntityManagerInterface $entityManager, PostRepository $postRepository)
    {
        $this->entityManager = $entityManager;
        $this->postRepository = $postRepository;
    }

    #[Route("/api/post/{id}/update", name:"api_post_update", methods: ['PUT'] )]
    public function update($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $post = $this->postRepository->findOneBy(['id' => $id]);
        $form = $this->createForm(PostType::class, $post);
        $form->submit($data);


        $this->entityManager->persist($post);
        $this->entityManager->flush();

        return $this->json($post, 201, [], ['groups' => 'post:read']);
    }
}
