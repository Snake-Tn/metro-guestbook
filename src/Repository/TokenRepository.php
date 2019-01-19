<?php

namespace Repository;


use Security\Token;

class TokenRepository
{
    private $connection;

    public function __construct(\Redis $connection)
    {
        $this->connection = $connection;
    }

    public function persist(Token $token): void
    {
        $this->connection->set($token->getToken(), $token->getUser()->getId(), $token->getExpiresIn());
    }

}