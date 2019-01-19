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
                        $this->getInstance(\Repository\EntryRepository::class),
                        $this->getInstance(\Repository\EntryTypeRepository::class),
                        $this->getInstance(\Converter\ArrayToEntryObjectConverter::class)
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
                        $this->getInstance(\Database\MariadbConnector::class)->getConnection()
                    );
                    break;

                case \Repository\TokenRepository::class :
                    $this->services[$serviceId] = new \Repository\TokenRepository(
                        $this->getInstance(\Database\RedisConnector::class)->getConnection()
                    );
                    break;

                case \Converter\ArrayToEntryObjectConverter::class:
                    $this->services[$serviceId] = new \Converter\ArrayToEntryObjectConverter;
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

                default:
                    throw new Exception(sprintf("service [%s] is not defined", $serviceId));

            }
        }
        return $this->services[$serviceId];
    }
}