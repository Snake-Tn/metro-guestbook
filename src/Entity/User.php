<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

namespace Entity;


class User
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var string
     */
    private $login;

    /**
     * @var string
     */
    private $passwordHash;

    /**
     * @var UserRole
     */
    private $role;

    /**
     * @param string $id
     * @param string $login
     * @param string $passwordHash
     * @param UserRole $role
     */
    public function __construct(string $id, string $login, string $passwordHash, UserRole $role)
    {
        $this->id = $id;
        $this->login = $login;
        $this->passwordHash = $passwordHash;
        $this->role = $role;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getLogin(): string
    {
        return $this->login;
    }

    /**
     * @return string
     */
    public function getPasswordHash(): string
    {
        return $this->passwordHash;
    }

    /**
     * @return UserRole
     */
    public function getRole(): UserRole
    {
        return $this->role;
    }



}