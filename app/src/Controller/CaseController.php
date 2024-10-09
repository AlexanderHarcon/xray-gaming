<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Winning;
use App\Repository\CSCaseRepository;
use App\Repository\ProductRepository;
use App\Repository\WinningRepository;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class CaseController extends AbstractController
{
    private UserService $userService;
    private ProductRepository $productRepository;
    private CSCaseRepository $CSCaseRepository;

    public function __construct(UserService $userService, ProductRepository $productRepository, CSCaseRepository $caseRepository)
    {
        $this->userService       = $userService;
        $this->productRepository = $productRepository;
        $this->CSCaseRepository  = $caseRepository;
    }

    #[Route('/case', name: 'case_page')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);

        return $this->render('case.html.twig',
            [
                'username' => $username,
                'error' => $error,
                'last_username' => $lastUsername
            ]);
    }

    #[Route('/case/{id}', name: 'case_id')]
    public function product($id): Response
    {
        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);

        //виклик назви кейсу на сторінці продукту
        $case     = $this->CSCaseRepository->find($id);
        $caseName = $case->getName();
        $caseImg  = $case->getImagePath();

        $products    = $this->productRepository->findBy(['cSCase' => $id]);
        $productsWin = [];
        foreach ($products as $product) {
            $productsWin[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'imagePath' => $product->getImagePath(),
            ];
        }
        return $this->render('case.html.twig',
            [
                'last_username' => '',
                'error' => null,
                'username' => $username,
                'productsWin' => $productsWin,
                'caseName' => $caseName,
                'caseId' => $id,
                'caseImagePath' => $caseImg,
            ]);
    }

    #[Route('/case/{id}/winning', name: 'case_winning', methods: ['POST'])]
    public function randomProduct($id, EntityManagerInterface $entityManager): JsonResponse
    {
        // Отримуємо користувача
        $user = $this->getUser();

        // Отримуємо масив продуктів для конкретного кейсу за ID
        $products = $this->productRepository->findBy(['cSCase' => $id]);

        if (empty($user)) {
            return new JsonResponse(['success' => false, 'redirect' => $this->generateUrl('app_login')], 401);
        }
        if (empty($products)) {
            return new JsonResponse(['success' => false, 'message' => 'Продукти не знайдено'], 404);
        }
        // dump($id);die;
        // Рандомізація продукту
        $randomProduct = $products[array_rand($products)];

        // Запис у базу даних виграшу
        $winning = new Winning();
        $winning->setUserID($user);
        $winning->setProductID($randomProduct);
        $winning->setCreatedAt(new \DateTime());

        $entityManager->persist($winning);
        $entityManager->flush();

        // Повертаємо успішний результат у JSON
        return new JsonResponse(
            [
                'success' => true,
                'product_id' => $randomProduct->getId()
            ]);
    }


}
