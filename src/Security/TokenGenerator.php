<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Security;


use Entity\User;

class TokenGenerator implements TokenGeneratorInterface
{

    const TOKEN_LIFE_TIME_IN_SECOND = 3600;

    /**
     * @param User $user
     * @return Token
     */
    public function generate(User $user): Token
    {
        return new Token(
            md5(uniqid((string)rand(), true)),
            $user,
            self::TOKEN_LIFE_TIME_IN_SECOND * 60 * 60 * 24 * 30 // 30 days
        );
    }
}