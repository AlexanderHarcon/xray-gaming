<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\UserService;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\User\UserInterface;

class MainPageController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/', name: 'main_page')]
    public function index(Security $security, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);

        return $this->render('index.html.twig', ['last_username' => '', 'error' => null, 'username' => $username]);
    }


}