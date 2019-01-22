<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Builder;

use Entity\Entry;
use Entity\User;
use Repository\EntryTypeRepository;

class EntryBuilder
{
    /**
     * @var EntryTypeRepository
     */
    private $entryTypeRepository;

    public function __construct(EntryTypeRepository $entryTypeRepository)
    {
        $this->entryTypeRepository = $entryTypeRepository;
    }

    /**
     * @var string
     */
    private $typeCode;

    /**
     * @var string
     */
    private $content;

    /**
     * @var User
     */
    private $owner;

    /**
     * @param string $typeCode
     * @return EntryBuilder
     */
    public function setTypeCode(string $typeCode): EntryBuilder
    {
        $this->typeCode = $typeCode;
        return $this;
    }

    /**
     * @param string $content
     * @return EntryBuilder
     */
    public function setContent(string $content): EntryBuilder
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @param User $owner
     * @return EntryBuilder
     */
    public function setOwner(User $owner): EntryBuilder
    {
        $this->owner = $owner;
        return $this;
    }


    public function build(): Entry
    {
        $entryType = $this->entryTypeRepository->fetchByCode($this->typeCode);
        return new Entry(null, $entryType, $this->content, $this->owner);
    }


}