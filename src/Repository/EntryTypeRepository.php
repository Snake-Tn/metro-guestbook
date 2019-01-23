<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Repository;

use Entity\EntryType;
use Exception\NotFoundException;

class EntryTypeRepository extends AbstractEntityRepository
{

    public function fetchAll()
    {
        $statement = $this->getConnection()->prepare(
            "SELECT * FROM entry_type"
        );

        $raws = $statement->fetch();
    }

    /**
     * @param string $code
     * @return EntryType
     * @throws NotFoundException
     */
    public function fetchByCode(string $code): EntryType
    {
        return $this->fetchByParameter('code', $code);
    }

    /**
     * @param string $id
     * @return EntryType
     * @throws NotFoundException
     */
    public function fetchById(string $id): EntryType
    {
        return $this->fetchByParameter('id', $id);
    }

    /**
     * @param string $parameterName
     * @param $parameterValue
     * @return EntryType
     * @throws NotFoundException
     */
    public function fetchByParameter(string $parameterName, $parameterValue): EntryType
    {
        $statement = $this->getConnection()->prepare(
            "SELECT id, code FROM entry_type WHERE $parameterName=:$parameterName"
        );
        $statement->bindValue(":$parameterName", $parameterValue);
        $statement->execute();
        $raw = $statement->fetch(\PDO::FETCH_ASSOC);
        if (empty($raw)) {
            throw new NotFoundException(sprintf("entry type having [$parameterName=%s] not found", $parameterValue));
        }

        return new EntryType($raw['id'], $raw['code']);
    }
}