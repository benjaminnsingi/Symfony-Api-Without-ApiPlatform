<?php

namespace App\Controller\Post;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

final class GetOneArticleController extends AbstractController
{
     private PostRepository $postRepository;

     public function __construct(PostRepository $postRepository)
     {
         $this->postRepository = $postRepository;
     }

    /**
     * @throws ExceptionInterface
     */
    #[Route("/api/post/show/{id}", name:"api_post_show", methods: ['GET'] )]
     public function show($id,NormalizerInterface $normalizer): Response
    {
         $post = $this->postRepository->findOneBy(['id' => $id]);
         $postNormalizes = $normalizer->normalize($post, 'json', ['groups' => 'post:read']);
         $json = json_encode($postNormalizes);
         return new Response($json, 200, [
             "Content-Type" => "application/json"
         ]);
     }
}
