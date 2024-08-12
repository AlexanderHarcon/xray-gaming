<?php

declare(strict_types = 1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PublisherController extends AbstractController
{
    #[Route('/publisher')]
    public function index(): Response
    {
        return $this->render('publisher/index.html.twig');
    }
}
