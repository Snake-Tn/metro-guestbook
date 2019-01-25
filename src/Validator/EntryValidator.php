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
        $errors = [];
        if (empty($entry['content'])) {
            $errors[] = new ValidationError('empty_content', "Content is empty");
        }

        if (empty($entry['type'])) {
            $errors[] = new ValidationError('type_content', "Type is empty");
        }

        return $errors;
    }

}