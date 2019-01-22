<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Repository;

use Exception\NotFoundException;
use Security\Token;
use Transformer\ArrayToUserTransformer;
use Transformer\UserToArrayTransformer;

class TokenRepository
{
    private $connection;

    private $userToArrayTransformer;
    private $arrayToUserTransformer;

    public function __construct(
        \Redis $connection,
        UserToArrayTransformer $userToArrayTransformer,
        ArrayToUserTransformer $arrayToUserTransformer
    )
    {
        $this->connection = $connection;
        $this->userToArrayTransformer = $userToArrayTransformer;
        $this->arrayToUserTransformer = $arrayToUserTransformer;
    }

    public function persist(Token $token): void
    {
        $userAsArray = $this->userToArrayTransformer->transform($token->getUser());
        $this->connection->set($token->getTokenKey(), json_encode($userAsArray), $token->getExpiresIn());
    }

    /**
     * @param string $tokenKey
     * @return Token
     * @throws NotFoundException
     */
    public function fetchByKey(string $tokenKey): Token
    {
        $encodedUser = $this->connection->get($tokenKey);
        if (empty($encodedUser)) {
            throw new NotFoundException(sprintf("token having key %s not found", $tokenKey));
        }
        $userAsArray = json_decode($encodedUser, true);
        $user = $this->arrayToUserTransformer->transform($userAsArray);

        return new Token($tokenKey, $user, 0);
    }

}