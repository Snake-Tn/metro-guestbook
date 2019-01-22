<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Controller;

use Builder\EntryBuilder;
use Transformer\ArrayToEntryTransformer;
use Transformer\ConverterInterface;
use Http\Request;
use Http\Response;
use Repository\EntryRepository;
use Repository\TokenRepository;

class EntryController extends AbstractController
{
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

        return new Response('', Response::JSON_CONTENT_TYPE, Response::OK);
    }

    public function approve(Request $request): Response
    {
        $entry = $this->entryRepository->fetchById($request->get('param1'));
        $this->denyAccessUnlessGranted('approve_entry');


    }

    public function update(Request $request): Response
    {
        $this->denyAccessUnlessGranted('update_entry');
    }

    public function delete(Request $request): Response
    {
        $this->denyAccessUnlessGranted('delete_entry');
    }

    public function show(Request $request): Response
    {
        $this->denyAccessUnlessGranted('show_entry');
    }
}