<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AboutUsController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    #[Route('/about-us', name: 'aboutUs_page')]
    public function index(): Response
    {
        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);

        return $this->render('aboutUs.html.twig', ['email' => $user->getUserIdentifier(), 'username' => $username, 'error' => null, 'last_username' => '',]);
    }
}
