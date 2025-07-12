<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

final class UserController extends AbstractController
{
    #[Route('/user/register', name: 'app_user')]
    public function register(EntityManagerInterface $entityManager ,  UserPasswordHasherInterface $passwordHasher): Response
    {
      if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $user = new User();
        $user->setEmail($_POST["email"]);
        $user->setNom($_POST["nom"]);
        $user->setPrenom($_POST["prenom"]);
        $user->setRoles([$_POST['role']]);
        $plaintextPassword = $_POST["password"];
         $hashedPassword = $passwordHasher->hashPassword(
            $user,
            $plaintextPassword
        );
        $user->setPassword($hashedPassword);
    $entityManager->persist($user);
    $entityManager->flush();
    return $this->redirectToRoute('app_login');
    }
        
        return $this->render('user/index.html.twig', [
            // 'form' => $form,
        ]);
    }
}
