<?php

namespace App\Controller\Post;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;


final class GetArticlesListController extends AbstractController
{
     private PostRepository $postRepository;

     public function __construct(PostRepository $repository)
     {
         $this->postRepository = $repository;
     }

    /**
     * @throws ExceptionInterface
     */
    #[Route("/api/post/list", name:"api_post_list", methods: ['GET'] )]
     public function index(SerializerInterface $serializer)
     {
         $posts = $this->postRepository->findAll();
         $postsNormalizes = $serializer->normalize($posts,'json', ['groups' => 'post:read'] );
         $json = json_encode($postsNormalizes);
         $response = new Response($json, 200, [
            "Content-Type" => "application/json"
         ]);

         return $response;
     }
}
