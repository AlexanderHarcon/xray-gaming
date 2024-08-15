<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Repository\ProductRepository;
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
    private ProductRepository $productRepository;

    public function __construct(UserService $userService, ProductRepository $productRepository)
    {
        $this->userService       = $userService;
        $this->productRepository = $productRepository;
    }

    #[Route('/', name: 'main_page')]
    public function index(): Response
    {
        $user        = $this->getUser();
        $username    = $this->userService->prepareUsername($user);
        $products    = $this->productRepository->findAll();

        $productsMap = [];
        foreach ($products as $product) {
            $category                 = $product->getCategoryID()->getName();
            $productsMap[$category][] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'imagePath' => $product->getImagePath(),
                'price' => $product->getPrice(),
            ];
        }

        return $this->render(
            'index.html.twig',
            [
                'last_username' => '',
                'error' => null,
                'username' => $username,
                'productsMap' => $productsMap,
            ],
        );
    }
}