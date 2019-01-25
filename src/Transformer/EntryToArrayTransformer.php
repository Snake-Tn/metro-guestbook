<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

namespace Transformer;


use Entity\Entry;

class EntryToArrayTransformer
{
    /**
     * @param Entry $entry
     * @return array
     */
    public function transform(Entry $entry): array
    {
        return [
            'id' => $entry->getId(),
            'content' => $entry->getContent(),
            'type' => $entry->getType()->getCode(),
            'is_approved' => $entry->isApproved()
        ];
    }

}