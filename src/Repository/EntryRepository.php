<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Repository;


use Entity\Entry;

class EntryRepository extends AbstractEntityRepository
{

    public function fetchById(string $id)
    {
        $statement = $this->getConnection()->prepare("
        
        SELECT `entry`.`id`,
        `entry`.`content`,
        `entry`.`created_at`,
        `entry`.`updated_at`,
        `entry`.`is_approved`,
        `entry`.`owner_id`,
        `entry`.`approver_id`,
        `entry`.`entry_type_id`
        FROM `entry` WHERE `entry`.`id`=:id;
        ");

        $statement->bindValue(':id', $id);
        $statement->execute();
        $raw = $statement->fetch(\PDO::FETCH_ASSOC);


    }

    public function persist(Entry $entry)
    {
        $statement = $this->getConnection()->prepare(

            "INSERT INTO `entry`
                        (`content`,`is_approved`,`owner_id`,`entry_type_id`,`updated_at`,`created_at`)
                        VALUES                        
                        (:content,0,:owner_id,:entry_type_id,NOW(),NOW())"
        );

        $statement->bindValue("content", $entry->getContent());
        $statement->bindValue("owner_id", $entry->getOwner()->getId());
        $statement->bindValue("entry_type_id", $entry->getType()->getId());
        $statement->execute();
    }

}