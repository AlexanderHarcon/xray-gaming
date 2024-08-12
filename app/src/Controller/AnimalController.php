<?php

declare(strict_types = 1);

namespace App\Controller;


use App\Entity\Animal;
use App\Repository\AnimalRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Error\ClassNotFoundError;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AnimalController extends AbstractController
{
    public function __construct(
        private AnimalRepository $animalRepository
    )
    {
    }
//    #[Route('/animal/{id}')]
//    public function create(EntityManagerInterface $entityManager): Response
//    {
//        $animal = new Animal();
//        $animal->setSpecies('Tiger');
//        $animal->setColor('blue');
//        $animal->setWeight(102);
//        $animal->setHasFur(true);
//
////        $entityManager->persist($animal); /*внесення у БД*/
////        $entityManager->flush();
//
//        return new Response('Product created with id ' . $animal->getSpecies());
//    }
//    #[Route('/animal/{id}')]
//    public function show(Animal $animal): Response
//    {
//        $animalStat = $animal->getSpecies() . '- species, ' . $animal->getColor() . '- color, ' . $animal->getWeight() . '- weight, ' . $animal->hasFur() . '- has fur.';
//        return new Response('Animal stat: ' . $animalStat);
//    }
//    #[Route('/animal/{id}', name: 'api_animal')]
//    public function apiAnimal(int $id): Response
//    {
//        $apianimal = $this->animalRepository->find($id);
//        if (null === $apianimal) {
//            throw $this->createNotFoundException();
//
//        }
//        return new Response($apianimal->getSpecies());
//    }
    #[Route('/animal/search', name: 'search_animal')]
    public function searchAnimal(): Response
    {
        $animalSearch = $this->animalRepository->findByWeight(11);
        $response     = '';
        foreach ($animalSearch as $animalStrokaYobana) {
            $response .= 'Species: ' . $animalStrokaYobana->getSpecies() . '. ' . 'Weight: ' . $animalStrokaYobana->getWeight() . '. ';
        }
        return new Response($response);

    }

    #[Route('/animal/weight', name: 'animal_weight')]
    public function weightAnimal(): Response
    {
        $animalWeight = $this->animalRepository->findAll();
        $anWeight     = 0;
        foreach ($animalWeight as $animalW) {
            $anWeight += $animalW->getWeight();
        }
        return new Response((string)$anWeight);
    }

}


