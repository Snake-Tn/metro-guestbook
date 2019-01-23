<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Transformer;

use Entity\User;
use Entity\UserRole;

class ArrayToUserTransformer
{
    /**
     * @param array $userAsArray
     * @return User
     */
    public function transform(array $userAsArray): user
    {
        return new User($userAsArray['id'], $userAsArray['login'], $userAsArray['password_hash'], new UserRole($userAsArray['role_id'], $userAsArray['role_code']));
    }
}