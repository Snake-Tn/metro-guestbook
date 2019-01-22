<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Entity;

/**
 * @see https://en.wikipedia.org/wiki/Null_object_pattern
 */
class NullUser extends User
{

    public function __construct()
    {
        parent::__construct(null, '', '', new UserRole(null, ''));
    }

}