<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class OrderController extends AbstractController
{
    #[Route('/order', name: 'order')]
    public function getOrders(EntityManagerInterface $entityManager): Response
    {

        return $this->render('order.html.twig');

    }
}
