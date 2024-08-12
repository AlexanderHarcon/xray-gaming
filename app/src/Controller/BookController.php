<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Repository\BookRepository;
use mysql_xdevapi\Result;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BookController extends AbstractController
{
    public function __construct(private readonly BookRepository $bookRepository)
    {
    }

    #[Route('/book')]
    public function findDate(): Response
    {
        $findDate = $this->bookRepository->findByPublishedDate('2013-05-14');
        $findBook = ' ';
        foreach ($findDate as $book) {
            $findBook .= $book->getAuthor() . ', ' . $book->getTitle() . ' - ' . $book->getPublishedDate()->format('d.m.Y') . '. </br>';
        }
        return new Response($findBook);
    }

    #[Route('/book/{author}')]
    public function findAuthor($author): JsonResponse
    {
        $books  = $this->bookRepository->findBy(['author' => $author]);
        $result = [];
        foreach ($books as $book) {
            $result[] = [
                'title' => $book->getTitle(),
                'author' => $book->getAuthor(),
                'price' => $book->getPrice(),
                'publishedDate' => $book->getPublishedDate()->format('d.m.Y'),
            ];;
        }

        return new JsonResponse($result);
    }
    #[Route('/books')]
    public function getBooks(): JsonResponse
    {
        $books = $this->bookRepository->findAll();
        $result = [];
        foreach ($books as $book ){
//        dump();die;
            $result[] = [
                'title' => $book->getTitle(),
                'publisherName' => $book->getPublisherId()->getName(),
                'publisherWebSite' => $book->getPublisherId()->getWebsite(),
                'price' => $book->getPrice(),
                'publishedDate' => $book->getPublishedDate()->format('d.m.Y'),
            ];
        }
        return new JsonResponse($result);
    }
    #[Route('/twig')]
    public function getTwig(): Response
    {
        // get the user information and notifications somehow
        $userFirstName = 'WWW';
        $userNotifications = ['Q', 'W', 'W'];

        // the template path is the relative file path from `templates/`
        return $this->render('user/notifications.html.twig', [
            // this array defines the variables passed to the template,
            // where the key is the variable name and the value is the variable value
            // (Twig recommends using snake_case variable names: 'foo_bar' instead of 'fooBar')
            'user_first_name' => $userFirstName,
            'notifications' => $userNotifications,
        ]);
    }


}

