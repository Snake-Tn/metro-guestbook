<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

namespace Entity;


class Entry
{
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
     * @var /DateTime
     */
    private $updatedAt;

    /**
     * Entry constructor.
     * @param string $type
     * @param string $content
     * @param User $owner
     */
    public function __construct(string $type, string $content, User $owner)
    {
        $this->content = $content;
    }

}