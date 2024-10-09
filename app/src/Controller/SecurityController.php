<?php

namespace App\Controller;

use App\Repository\CSCaseRepository;
use App\Repository\ProductRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private CSCaseRepository $cscaseRepository;

    public function __construct( cscaseRepository $cscaseRepository)
    {
        $this->cscaseRepository = $cscaseRepository;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $products     = $this->cscaseRepository->findAll();

        $productsMap = [];
        foreach ($products as $product) {
            $category                 = $product->getCategory()->getName();
            $productsMap[$category][] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'imagePath' => $product->getImagePath(),
                'price' => $product->getPrice(),
            ];
        }
        return $this->render('index.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'productsMap' => $productsMap,
        ]);
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(Security $security): void
    {
        $security->logout();
    }
}
