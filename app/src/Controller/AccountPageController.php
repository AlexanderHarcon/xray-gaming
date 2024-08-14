<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AccountPageController extends AbstractController
{
    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    #[Route('/account', name: 'account_page')]
    public function account(): Response
    {
        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);
        return $this->render('account.html.twig', ['email' => $user->getUserIdentifier(), 'username' => $username, 'error' => null, 'last_username' => '',]);

    }
}
