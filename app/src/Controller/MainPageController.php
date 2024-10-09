<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Repository\CSCaseRepository;
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
    private CSCaseRepository $CSCaseRepository;

    public function __construct(UserService $userService, CSCaseRepository $caseRepository)
    {
        $this->userService      = $userService;
        $this->CSCaseRepository = $caseRepository;
    }

    #[Route('/', name: 'main_page')]
    public function index(): Response
    {
        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);
        $cases    = $this->CSCaseRepository->findAll();

        $casesMap = [];
        foreach ($cases as $case) {
            $category              = $case->getCategory()->getName();
            $casesMap[$category][] = [
                'id' => $case->getId(),
                'name' => $case->getName(),
                'imagePath' => $case->getImagePath(),
                'price' => $case->getPrice(),
            ];
        }

        return $this->render(
            'index.html.twig',
            [
                'last_username' => '',
                'error' => null,
                'username' => $username,
                'productsMap' => $casesMap,
            ],
        );
    }
}