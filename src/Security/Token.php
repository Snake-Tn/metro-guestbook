<?php

namespace Security;


use Entity\User;

class Token
{
    /**
     * @var string
     */
    private $token;
    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @var User
     */
    private $user;

    /**
     * @param string $token
     * @param string $userId
     * @param int $expiresIn
     */
    public function __construct(string $token, User $user, int $expiresIn)
    {
        $this->token = $token;
        $this->user = $user;
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }


}