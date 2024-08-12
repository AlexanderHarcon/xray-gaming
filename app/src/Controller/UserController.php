<?php

declare(strict_types = 1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{
    public function __construct(
        private readonly UserRepository $userRepository
    )
    {
    }

    #[Route('/registration', name: 'user_registration', methods: ['POST'])]
    public function register(UserPasswordHasherInterface $passwordHasher, Request $request, EntityManagerInterface $em): Response
    {
        $requestData = $request->request;

        $email = $requestData->get('email');
        if ($email === '') {
            throw new \LogicException('email is empty');
        }
        $password = $requestData->get('password');
        if ($password === '') {
            throw new \LogicException('password is empty');

        }
        $repeatPassword = $requestData->get('repeatPassword');

        if ($password !== $repeatPassword) {
            throw new \LogicException('Passwords don\'t match');
        }
        $user = new User();
        $user->setEmail($email);
        $hashPassword = $passwordHasher->hashPassword(
            $user,
            $password
        );
        $user->setPassword($hashPassword);

        $this->userRepository->save($user);

        return $this->redirectToRoute('main_page');
    }

    #[Route('/user_upgrade', name: 'user_upgrade', methods: ['POST'])]
    public function userUpgrade(UserPasswordHasherInterface $newHashedPassword, Request $request): Response
    {
        $requestData = $request->request;

        $newEmail          = $requestData->get('email');
        $password          = $requestData->get('password');
        $newPassword       = $requestData->get('newPassword');
        $confirmPassword   = $requestData->get('confirmPassword');
        $arePasswordsEmpty = $password === '' && $newPassword === '' && $confirmPassword === '';

        if (!$arePasswordsEmpty) {
            if ($newPassword !== $confirmPassword) {
                throw new \LogicException('Passwords don\'t match');
            }
            if ($newPassword == $password) {
                throw new \LogicException('The new password is identical to the old one');
            }
        }

        if ($newEmail === '') {
            throw new \LogicException('email is empty');
        }

        $user = $this->getUser();

        // Оновлення email
        if ($arePasswordsEmpty && $user->getUserIdentifier() !== $newEmail) {
            $this->userRepository->upgradeEmail($user, $newEmail);
        }

        if (!$arePasswordsEmpty && $newPassword) {
            $this->userRepository->upgradeEmail($user, $newEmail);
            $hashPassword = $newHashedPassword->hashPassword($user, $newPassword);
            $this->userRepository->upgradePassword($user, $hashPassword);
        }

        return $this->redirectToRoute('account_page');
    }

}
