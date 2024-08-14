<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CaseController extends AbstractController
{
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    #[Route('/case', name: 'case_page')]
    public function index(): Response
    {
        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);
        return $this->render('case.html.twig', ['username' => $username]);
    }


}
