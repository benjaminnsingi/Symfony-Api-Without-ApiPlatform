<?php

namespace App\Controller\Registration;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends AbstractController
{
    public function __construct(
    private EntityManagerInterface $entityManager,
    private UserPasswordHasherInterface $passwordHasher
    )
    {
    }

    #[Route("/auth/register", name:"api_register", methods: ['POST'] )]
    public function register(Request $request): JsonResponse
    {
       $data = json_decode($request->getContent(), true);

       $email = $data['email'];
       $password = $data['password'];

       $user = new User();

       $user->setEmail($email);
       $user->setPassword($this->passwordHasher->hashPassword($user, $password));
       $user->setRoles(['ROLE_USER']);

       $this->entityManager->persist($user);
       $this->entityManager->flush();

       return new JsonResponse(["success" => $user->getEmail(). "Vous êtes bien inscrit"], 200);
    }
}
