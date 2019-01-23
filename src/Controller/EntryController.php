<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Controller;

use Builder\EntryBuilder;
use Http\Request;
use Http\Response;
use Repository\EntryRepository;
use Repository\TokenRepository;

class EntryController extends AbstractController
{
    private $entryRepository;
    private $entryBuilder;


    public function __construct(
        TokenRepository $tokenRepository,
        EntryRepository $entryRepository,
        EntryBuilder $entryBuilder
    )
    {
        $this->entryRepository = $entryRepository;
        $this->entryBuilder = $entryBuilder;
        parent::__construct($tokenRepository);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception\BadRequestException
     * @throws \Exception\ForbiddenException
     * @throws \Exception\NotFoundException
     */
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted($request, 'create_entry');
        $entryAsArray = json_decode($request->getBody(), true);
        // @TODO add validation

        $entry = $this->entryBuilder->setContent($entryAsArray['content'])
            ->setTypeCode($entryAsArray['type'])
            ->setOwner($this->getToken($request)->getUser())
            ->build();

        $this->entryRepository->persist($entry);

        return new Response('', Response::JSON_CONTENT_TYPE, Response::CREATED);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception\BadRequestException
     * @throws \Exception\ForbiddenException
     * @throws \Exception\NotFoundException
     */
    public function approve(Request $request): Response
    {
        $this->denyAccessUnlessGranted($request, 'approve_entry');
        $entry = $this->entryRepository->fetchById($request->get('param1'));
        $entry->setApprover($this->getToken($request)->getUser());
        $this->entryRepository->persist($entry);

        return new Response('', Response::JSON_CONTENT_TYPE, Response::OK);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception\BadRequestException
     * @throws \Exception\ForbiddenException
     * @throws \Exception\NotFoundException
     */
    public function update(Request $request): Response
    {
        $entry = $this->entryRepository->fetchById($request->get('param1'));
        $this->denyAccessUnlessGranted($request, 'update_entry', $entry);

        $entryAsArray = json_decode($request->getBody(), true);
        $entry->setContent($entryAsArray['content']);

        $this->entryRepository->persist($entry);
        return new Response('', Response::JSON_CONTENT_TYPE, Response::OK);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception\BadRequestException
     * @throws \Exception\ForbiddenException
     * @throws \Exception\NotFoundException
     */
    public function delete(Request $request): Response
    {
        $entry = $this->entryRepository->fetchById($request->get('param1'));
        $this->denyAccessUnlessGranted($request, 'delete_entry', $entry);

        $this->entryRepository->remove($entry);
        return new Response('', Response::JSON_CONTENT_TYPE, Response::OK);
    }

    /**
     * @param Request $request
     * @return Response
     * @throws \Exception\ForbiddenException
     */
    public function show(Request $request): Response
    {
        $this->denyAccessUnlessGranted($request, 'show_entry');
        return new Response('', Response::JSON_CONTENT_TYPE, Response::OK);
    }
}