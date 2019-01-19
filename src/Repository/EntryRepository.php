<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Repository;


class EntryRepository extends AbstractEntityRepository
{


    public function persist(Entry $entry)
    {
        $this->getConnection()->prepare(
            "INSERT INTO `entry` () VALUES ()"
        );
    }

}