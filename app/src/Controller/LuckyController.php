<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use App\Repository\ShopProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ShopProduct;


class LuckyController extends AbstractController
{
    private ShopProductRepository $shopProductRepository;

    public function __construct(
        ShopProductRepository $shopProductRepository
    )
    {
        $this->shopProductRepository = $shopProductRepository;
    }

    #[Route('/lucky/number')]
    public function number(): Response
    {
        $number = random_int(0, 100);

        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

//    #[Route('/lucky/{id}', name: 'product show')]
//    public function show(int $id): Response
//    {
//        $product      = $this->shopProductRepository->find($id);
//        $priceProduct = $product->getPrice() * 3;
////        dump($product->getProducerMainName(), $product->getProducerFirstName());
//        if (!$product) {
//            throw $this->createNotFoundException(
//                'No product found for id ' . $id
//            );
//        }
//        return new Response('check out this great price: ' . $priceProduct . '</br>');
//    }

    #[Route('/lucky/search', name: 'search show')]
    public function search(): Response
    {
        $producerName = $this->shopProductRepository->findAll();

        $bankNolikov = 0;
        foreach ($producerName as $producer) {
            $bankNolikov += $producer->getPrice();
        }
        return new Response($bankNolikov);
    }
}
