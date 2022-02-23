<?php

namespace App\Controller\Post;

use App\Entity\Post;
use App\Form\PostType;
use Doctrine\ORM\EntityManagerInterface;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/post")]
final class CreatePostController extends AbstractController
{
   private FormFactoryInterface $formFactory;
   private EntityManagerInterface $entityManager;

   public function __construct(FormFactoryInterface $formFactory, EntityManagerInterface $entityManager)
   {
       $this->formFactory = $formFactory;
       $this->entityManager = $entityManager;
   }

    #[ArrayShape(['post' => "\App\Entity\Post"])] #[Route("/create", name:"api_post_created", methods: ['GET','POST'] )]
    #[NoReturn] public function create(Request $request): array
   {
       $post = new Post();

       $form = $this->formFactory->createNamed('post', PostType::class, $post);
       $form->submit($request->request->get('post'));

       dd($form);

       if ($form->isValid()) {
           $this->entityManager->persist($post);
           $this->entityManager->flush();

           return ['post' => $post ];
       }

       return ['post' => $form];
   }
}