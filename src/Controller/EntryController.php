<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Controller;

use Builder\EntryBuilder;
use Http\Request;
use Http\Response;
use ImageStorage\ImageStorageInterface;
use Repository\EntryRepository;
use Repository\TokenRepository;
use Transformer\EntryToArrayTransformer;

class EntryController extends AbstractController
{
    private $entryRepository;
    private $entryBuilder;
    private $entryToArrayTransformer;
    private $imageStorage;


    public function __construct(
        TokenRepository $tokenRepository,
        EntryRepository $entryRepository,
        EntryBuilder $entryBuilder,
        EntryToArrayTransformer $entryToArrayTransformer,
        ImageStorageInterface $imageStorage
    )
    {
        $this->entryRepository = $entryRepository;
        $this->entryBuilder = $entryBuilder;
        $this->entryToArrayTransformer = $entryToArrayTransformer;
        $this->imageStorage = $imageStorage;
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

        if ($request->hasFiles()) {
            $entryAsArray['type'] = 'image';
            $file = $request->getFile('entry');
            $entryAsArray['content'] = $this->imageStorage->save($file['tmp_name'], $file['type']);
        }
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
     * @throws \Exception\NotFoundException
     */
    public function list(Request $request): Response
    {
        if ($request->has('is_approved')) {
            $this->denyAccessUnlessGranted($request, 'show_approved_entries');
        } else {
            $this->denyAccessUnlessGranted($request, 'show_all_entries');
        }
        $entries = $this->entryRepository->fetchAll();
        $entriesAsArray = [];

        foreach ($entries as $entry) {
            if ($request->has('is_approved') && !$entry->isApproved()) {
                continue;
            }
            $entriesAsArray[] = $this->entryToArrayTransformer->transform($entry);
        }
        return new Response(json_encode($entriesAsArray), Response::JSON_CONTENT_TYPE, Response::OK);
    }
}