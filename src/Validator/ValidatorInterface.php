<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Validator;

interface ValidatorInterface
{
    /**
     * Validate input and return an array of errors if not valid, empty array if valid.
     * @param array $input array to validate
     * @return ValidationError[]
     */
    public function validate(array $input): array;

}