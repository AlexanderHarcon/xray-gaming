<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyWinningsController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/myWinnings', name: 'my_winnings')]
    public function index(): Response
    {
        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);
        return $this->render('myWinnings.html.twig', ['email' => $user->getUserIdentifier(), 'username' => $username, 'error' => null, 'last_username' => '',]);
    }
}
