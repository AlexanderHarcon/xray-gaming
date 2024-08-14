<?php

namespace App\Service;

use Symfony\Component\Security\Core\User\UserInterface;

class UserService
{
    public function prepareUsername(?UserInterface $user): string
    {
        if ($user === null) {
            return 'Guest'; // або будь-яке інше значення для неавторизованого користувача
        }
        $email    = $user->getUserIdentifier();
        $parts    = explode("@", $email);
        $username = isset($parts[0]) ? $parts[0] : "Invalid email format";

        return $username;
    }
}