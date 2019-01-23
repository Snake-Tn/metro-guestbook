<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Security;


use Entity\User;

interface TokenGeneratorInterface
{

    /**
     * @param User $user
     * @return Token
     */
    public function generate(User $user): Token;

}