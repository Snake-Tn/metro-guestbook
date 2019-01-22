<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Transformer;

use Entity\User;

class UserToArrayTransformer
{
    public function transform(User $user): array
    {
        return [
            'id' => $user->getId(),
            'login' => $user->getLogin(),
            'password_hash' => $user->getPasswordHash(),
            'role_id' => $user->getRole()->getId(),
            'role_code' => $user->getRole()->getCode()
        ];
    }

}