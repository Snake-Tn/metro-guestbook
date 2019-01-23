<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Entity;

class Entry
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var EntryType
     */
    private $type;

    /**
     * @var string
     */
    private $content;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var User
     */
    private $approver;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Entry constructor.
     * @param null|string $id
     * @param EntryType $type
     * @param string $content
     * @param User $owner
     */
    public function __construct(?string $id, EntryType $type, string $content, User $owner)
    {
        $this->id = $id;
        $this->type = $type;
        $this->content = $content;
        $this->owner = $owner;
        $this->approver = new NullUser();
    }

    /**
     * @return string
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @return EntryType
     */
    public function getType(): EntryType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @return User
     */
    public function getOwner(): User
    {
        return $this->owner;
    }

    /**
     * @return User
     */
    public function getApprover(): User
    {
        return $this->approver;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param User $approver
     */
    public function setApprover(User $approver): void
    {
        $this->approver = $approver;
    }

    /**
     * @param string $content
     */
    public function setContent(string $content): void
    {
        $this->content = $content;
    }


}