<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Validator;

class EntryValidator implements ValidatorInterface
{
    /**
     * @param array $entry
     * @return ValidationError[]
     */
    public function validate(array $entry): array
    {
        return [];
    }

}