<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

class Container
{
    private $services;


    public function getInstance($serviceId)
    {
        if (!isset($this->services[$serviceId])) {
            switch ($serviceId) {
                case \Controller\EntryController::class :
                    $this->services[$serviceId] = (new \Controller\EntryController(
                        $this->getInstance(\Repository\TokenRepository::class),
                        $this->getInstance(\Repository\EntryRepository::class),
                        $this->getInstance(\Builder\EntryBuilder::class)
                    ))->addVoter($this->getInstance(\Security\Voter\EntryVoter::class));
                    break;

                case \Controller\AuthorizationController::class :
                    $this->services[$serviceId] = new \Controller\AuthorizationController(
                        $this->getInstance(\Repository\UserRepository::class),
                        $this->getInstance(\Security\TokenGenerator::class),
                        $this->getInstance(\Repository\TokenRepository::class)
                    );
                    break;

                case \Repository\EntryRepository::class :
                    $this->services[$serviceId] = new \Repository\EntryRepository(
                        $this->getInstance(\Repository\UserRepository::class),
                        $this->getInstance(\Repository\EntryTypeRepository::class),
                        $this->getInstance(\Database\MariadbConnector::class)->getConnection()
                    );
                    break;

                case \Repository\EntryTypeRepository::class :
                    $this->services[$serviceId] = new \Repository\EntryTypeRepository(
                        $this->getInstance(\Database\MariadbConnector::class)->getConnection()
                    );
                    break;

                case \Repository\UserRepository::class :
                    $this->services[$serviceId] = new \Repository\UserRepository(
                        $this->getInstance(\Transformer\ArrayToUserTransformer::class),
                        $this->getInstance(\Database\MariadbConnector::class)->getConnection()
                    );
                    break;

                case \Repository\TokenRepository::class :
                    $this->services[$serviceId] = new \Repository\TokenRepository(
                        $this->getInstance(\Database\RedisConnector::class)->getConnection(),
                        $this->getInstance(\Transformer\UserToArrayTransformer::class),
                        $this->getInstance(\Transformer\ArrayToUserTransformer::class)
                    );
                    break;

                case \Builder\EntryBuilder::class:
                    $this->services[$serviceId] = new \Builder\EntryBuilder(
                        $this->getInstance(\Repository\EntryTypeRepository::class)
                    );
                    break;

                case \Database\MariadbConnector::class:
                    $this->services[$serviceId] = new Database\MariadbConnector;
                    break;

                case \Database\RedisConnector::class:
                    $this->services[$serviceId] = new Database\RedisConnector;
                    break;

                case \Security\TokenGenerator::class:
                    $this->services[$serviceId] = new \Security\TokenGenerator;
                    break;

                case \Security\Voter\EntryVoter::class:
                    $this->services[$serviceId] = new \Security\Voter\EntryVoter;
                    break;

                case \Transformer\ArrayToUserTransformer::class:
                    $this->services[$serviceId] = new \Transformer\ArrayToUserTransformer;
                    break;

                case \Transformer\UserToArrayTransformer::class:
                    $this->services[$serviceId] = new \Transformer\UserToArrayTransformer;
                    break;

            }
        }
        return $this->services[$serviceId];
    }
}