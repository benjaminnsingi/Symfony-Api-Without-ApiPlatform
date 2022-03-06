<?php

namespace App\Controller\Post;

use App\Entity\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class CreatePostController extends AbstractController
{
   private EntityManagerInterface $entityManager;

   public function __construct(EntityManagerInterface $entityManager)
   {
       $this->entityManager = $entityManager;
   }

   #[Route("/api/post/create", name:"api_post_created", methods: ['POST'] )]
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
   {
       $data = $request->getContent();

       $post = $serializer->deserialize($data, Post::class, 'json');
       $post->setUser($this->getUser());

       $this->entityManager->persist($post);
       $this->entityManager->flush();

       return $this->json($post, 201, [], ['groups' => 'post:read']);
   }
}
