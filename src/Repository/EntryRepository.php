<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Repository;

use Entity\Entry;
use Exception\NotFoundException;

class EntryRepository extends AbstractEntityRepository
{

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var EntryTypeRepository
     */
    private $entryTypeRepository;

    /**
     * @param UserRepository $userRepository
     * @param EntryTypeRepository $entryTypeRepository
     * @param \PDO $connection
     */
    public function __construct(
        UserRepository $userRepository,
        EntryTypeRepository $entryTypeRepository,
        \PDO $connection
    )
    {
        $this->userRepository = $userRepository;
        $this->entryTypeRepository = $entryTypeRepository;
        parent::__construct($connection);
    }

    /**
     * @param string $id
     * @return Entry
     * @throws NotFoundException
     */
    public function fetchById(string $id): Entry
    {
        $statement = $this->getConnection()->prepare("        
        SELECT entry.id,
        entry.content,
        entry.created_at,
        entry.updated_at,        
        entry.owner_id,
        entry.approver_id,
        entry.entry_type_id
        FROM entry WHERE entry.id=:id");

        $statement->bindValue(':id', $id);
        $statement->execute();
        $raw = $statement->fetch(\PDO::FETCH_ASSOC);
        if (empty($raw)) {
            throw  new NotFoundException(sprintf("entry having [id=%s] not found", $id));
        }

        return new Entry(
            $raw['id'],
            $this->entryTypeRepository->fetchById($raw['entry_type_id']),
            $raw['content'],
            $this->userRepository->fetchById($raw['owner_id'])
        );
    }

    /**
     * Update or insert an entry.
     * @param Entry $entry
     */
    public function persist(Entry $entry):void
    {
        $statement = $this->getConnection()->prepare("INSERT INTO entry 
         (id,content,owner_id,approver_id,entry_type_id,updated_at,created_at)
         VALUES
         (:id,:content,:owner_id,:approver_id,:entry_type_id,NOW(),NOW())
         ON DUPLICATE KEY UPDATE content= :content2, approver_id= :approver_id2,updated_at= NOW()
        ");

        $statement->bindValue("id", $entry->getId());
        $statement->bindValue("content", $entry->getContent());
        $statement->bindValue("content2", $entry->getContent());
        $statement->bindValue("owner_id", $entry->getOwner()->getId());
        $statement->bindValue("entry_type_id", $entry->getType()->getId());
        $statement->bindValue("approver_id", $entry->getApprover()->getId());
        $statement->bindValue("approver_id2", $entry->getApprover()->getId());
        $statement->execute();
    }

    /**
     * @param Entry $entry
     */
    public function remove(Entry $entry):void
    {
        $statement = $this->getConnection()->prepare("DELETE FROM entry where id=:id");
        $statement->bindValue("id", $entry->getId());
        $statement->execute();
    }
}