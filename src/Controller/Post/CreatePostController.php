<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

final class CreatePostController extends AbstractController
{
   private FormFactoryInterface $formFactory;
   private EntityManagerInterface $entityManager;

   public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
   {
       $this->formFactory = $formFactory;
       $this->entityManager = $entityManager;
   }

   #[Route("/api/post/create", name:"api_post_created", methods: ['POST'] )]
    public function create(Request $request, SerializerInterface $serializer): JsonResponse
   {
       $jsonReceived = $request->getContent();

       $post = $serializer->deserialize($jsonReceived, Post::class, 'json');

       $this->entityManager->persist($post);
       $this->entityManager->flush();

       return $this->json($post, 201, [], ['groups' => 'post:read']);
   }
}
