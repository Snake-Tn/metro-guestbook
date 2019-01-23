<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Repository;


use Entity\User;
use Exception\NotFoundException;
use Transformer\ArrayToUserTransformer;

class UserRepository extends AbstractEntityRepository
{
    /**
     * @var ArrayToUserTransformer
     */
    private $arrayToUserTransformer;

    /**
     * @param ArrayToUserTransformer $arrayToUserTransformer
     * @param \PDO $connection
     */
    public function __construct(
        ArrayToUserTransformer $arrayToUserTransformer,
        \PDO $connection
    )
    {
        $this->arrayToUserTransformer = $arrayToUserTransformer;
        parent::__construct($connection);
    }

    /**
     * @param string $id
     * @return User
     * @throws NotFoundException
     */
    public function fetchById(string $id): User
    {
        return $this->fetchByParameter('id', $id);
    }

    /**
     * @param string $login
     * @return User
     * @throws NotFoundException
     */
    public function fetchByLogin(string $login): User
    {
        return $this->fetchByParameter('login', $login);
    }

    /**
     * @param string $parameterName
     * @param $parameterValue
     * @return User
     * @throws NotFoundException
     */
    public function fetchByParameter(string $parameterName, $parameterValue): User
    {
        $statement = $this->getConnection()->prepare(
            "SELECT u.id, u.login, u.password_hash, u.role_id, ur.code AS role_code FROM user AS u 
                    INNER JOIN user_role AS ur ON ur.id=u.role_id
                    WHERE u.$parameterName=:$parameterName"
        );
        $statement->bindValue(":$parameterName", $parameterValue);
        $statement->execute();
        $raw = $statement->fetch(\PDO::FETCH_ASSOC);
        if (empty($raw)) {
            throw new NotFoundException(sprintf("user having [$parameterName=%s] not found", $parameterValue));
        }
        return $this->arrayToUserTransformer->transform($raw);
    }
}