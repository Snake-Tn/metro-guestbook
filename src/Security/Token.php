<?php

namespace Security;


use Entity\User;

class Token
{
    /**
     * @var string
     */
    private $tokenKey;

    /**
     * @var User
     */
    private $user;

    /**
     * @var int
     */
    private $expiresIn;

    /**
     * @param string $token
     * @param User $user
     * @param int $expiresIn
     */
    public function __construct(string $token, User $user, int $expiresIn)
    {
        $this->tokenKey = $token;
        $this->user = $user;
        $this->expiresIn = $expiresIn;
    }

    /**
     * @return string
     */
    public function getTokenKey(): string
    {
        return $this->tokenKey;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @return int
     */
    public function getExpiresIn(): int
    {
        return $this->expiresIn;
    }


}