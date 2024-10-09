<?php

declare(strict_types = 1);

namespace App\Controller;

use _PHPStan_c4c026984\Composer\XdebugHandler\Status;
use App\Entity\Order;
use App\Enum\OrderStatus;
use App\Repository\OrderRepository;
use App\Service\UserService;
use App\Repository\WinningRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;


class MyWinningsController extends AbstractController
{
    private $userService;
    private $winningRepository;
    private $orderRepository;

    public function __construct(UserService $userService, WinningRepository $winningRepository, OrderRepository $orderRepository)
    {
        $this->userService       = $userService;
        $this->winningRepository = $winningRepository;
        $this->orderRepository   = $orderRepository;

    }

    #[Route('/myWinnings', name: 'my_winnings')]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error        = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        $user     = $this->getUser();
        $username = $this->userService->prepareUsername($user);
        $winnings = $this->winningRepository->findBy(['userID' => $user], ['createdAt' => 'DESC']);

        return $this->render('myWinnings.html.twig', [
            'username' => $username,
            'error' => $error,
            'last_username' => $lastUsername,
            'winnings' => $winnings,
        ]);
    }

    #[Route('/newOrder', name: 'newOrder', methods: ['POST'])]
    public function newOrder(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Отримуємо вміст запиту (JSON) як рядок
        $requestData = $request->getContent();

        // Перетворюємо JSON у масив
        $data = json_decode($requestData, true);

        // Перевіряємо чи дані != 0
        if (isset($data['winningIDs']) && count($data['winningIDs']) > 0) {
            $winningIDs = array_unique($data['winningIDs']);
            $user       = $this->getUser();
            $winnings   = $this->winningRepository->findBy(['userID' => $user, 'id' => $winningIDs]);

            $getPrice = 0;
            $winID = [];
            foreach ($winnings as $winning) {
                $winID[]    = $winning->getProductID()->getId();
                $getPrice += $winning->getProductID()->getPrice();
            }
//            dump($winID);die;
            $date = (new \DateTimeImmutable())->setTimezone(new \DateTimeZone('Europe/Kiev'));

            $order = new Order();
            $order->setProductID($winID);
            $order->setCoinPrice($getPrice);
            $order->setDateAt($date);
            $order->setStatus(OrderStatus::NEW);
            $entityManager->persist($order);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'winningIDs' => $winningIDs
            ]);
        }
        // Якщо дані не знайдено, повертаємо помилку
        return new JsonResponse([
            'success' => false,
            'message' => 'Немає даних'
        ],
            400);
    }
}
