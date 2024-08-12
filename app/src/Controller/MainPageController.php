<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MainPageController extends AbstractController
{
    #[Route('/', name: 'main_page')]
    public function index(Security $security, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user     = $this->getUser();
        $username = $this->prepareUsername($user);

        return $this->render('index.html.twig', ['last_username' => '', 'error' => null, 'username' => $username]);
    }

    #[Route('/account', name: 'account_page')]
    public function account(): Response
    {
        $user = $this->getUser();

        $username = $this->prepareUsername($user);

        return $this->render('account.html.twig', ['email' => $user->getUserIdentifier(), 'username' => $username, 'error' => null,'last_username' => '',]);

    }

    private function prepareUsername(?UserInterface $user): string
    {
        if ($user === null) {
            return 'Guest'; // або будь-яке інше значення для неавторизованого користувача
        }
        $email    = $user->getUserIdentifier();
        $parts    = explode("@", $email);
        $username = isset($parts[0]) ? $parts[0] : "Invalid email format";

        return $username;
    }
}