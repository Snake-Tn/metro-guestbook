<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Tests\Controller;

use Controller\Api\GuestNoteController;
use Controller\EntryController;
use Exception\NotFoundException;
use Transformer\JsonToRestaurantCollectionConverter;
use DataAccess\FileDataAccess;
use Exception\BadRequestException;
use Exception\ForbiddenException;
use Http\Request;
use PHPUnit\Framework\TestCase;
use Repository\EntryRepository;
use Repository\SortCriteriaRepository;
use Repository\TokenRepository;

class EntryControllerTest extends TestCase
{


    function test_create_case_request_missing_token()
    {
        $this->expectException(ForbiddenException::class);
        $controller = new EntryController($this->createMock(TokenRepository::class));
        $request = new Request();
        $controller->create($request);
    }

    function test_create_case_unknown_given_token()
    {
        $this->expectException(ForbiddenException::class);
        $tokenRepositoryMock = $this->createMock(TokenRepository::class);
        $tokenRepositoryMock->method('fetchByKey')
            ->with('some_unkown_token')
            ->willThrowException(new NotFoundException());

        $controller = new EntryController($tokenRepositoryMock);
        $request = new Request();
        $request->setHeaders(['Authorization' => 'Bearer some_unkown_token']);
        $controller->create($request);
    }


}