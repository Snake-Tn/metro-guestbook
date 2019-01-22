<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Security;


use Entity\User;

interface TokenGeneratorInterface
{

    public function generate(User $user): Token;

}