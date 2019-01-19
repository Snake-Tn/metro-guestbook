<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Controller;

use Converter\ArrayToEntryObjectConverter;
use Converter\ConverterInterface;
use Http\Request;
use Http\Response;
use Repository\EntryRepository;
use Repository\EntryTypeRepository;

class EntryController extends AbstractController
{
    private $entryRepository;
    private $entryTypeRepository;
    private $converter;

    public function __construct(
        EntryRepository $entryRepository,
        EntryTypeRepository $entryTypeRepository,
        ArrayToEntryObjectConverter $converter
    )
    {
        $this->entryRepository = $entryRepository;
        $this->entryTypeRepository = $entryTypeRepository;
        $this->converter = $converter;
    }


    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('create_entry');
        $entry = $this->converter->convert(json_decode($request->getBody(), true));
        $this->entryTypeRepository->fetchByType("image");
        $this->entryRepository->persist($entry);
    }

    public function approve(Request $request): Response
    {
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