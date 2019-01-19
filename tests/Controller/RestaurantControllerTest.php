<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

namespace Tests\Controller;

use Controller\Api\GuestNoteController;
use Converter\JsonToRestaurantCollectionConverter;
use DataAccess\FileDataAccess;
use Exception\BadRequestException;
use Http\Request;
use PHPUnit\Framework\TestCase;
use Repository\EntryRepository;
use Repository\SortCriteriaRepository;

class RestaurantControllerTest extends TestCase
{

    /**
     * @var GuestNoteController
     */
    private $restaurantController;
    private $dataAccessMock;

    function setUp()
    {
        $this->dataAccessMock = $this->createMock(FileDataAccess::class);

        $this->restaurantController = new GuestNoteController(
            new EntryRepository($this->dataAccessMock, new JsonToRestaurantCollectionConverter()
                , 'dump_file_url'),
            new SortCriteriaRepository($this->dataAccessMock, 'dump_file_url'),
            new \Symfony\Component\Serializer\Serializer([new \Symfony\Component\Serializer\Normalizer\PropertyNormalizer()], [new \Symfony\Component\Serializer\Encoder\JsonEncoder()]
            )
        );
    }

    function test_search_case_empty_data_source()
    {
        $response = $this->restaurantController->search(new Request());
        $this->assertEquals('[]', $response->content);
    }

    function test_search_case_data_source_not_empty()
    {
        $this->dataAccessMock->method("read")->willReturn(file_get_contents(__DIR__ . '/../Fixtures/restaurants.json'));
        $request = new Request();
        $response = $this->restaurantController->search($request);
        $this->assertEquals("[{\"name\":\"Restaurant 1\",\"status\":\"open\",\"features\":[{\"code\":\"status\",\"value\":2},{\"code\":\"feature_1\",\"value\":1},{\"code\":\"feature_2\",\"value\":999999}]},{\"name\":\"Restaurant 2\",\"status\":\"closed\",\"features\":[{\"code\":\"status\",\"value\":0},{\"code\":\"feature_1\",\"value\":2},{\"code\":\"feature_2\",\"value\":0.07}]}]", $response->content);
        $this->assertEquals(200, $response->code);
    }

    function test_search_case_filter_by_name()
    {
        $this->dataAccessMock->method("read")->willReturn(file_get_contents(__DIR__ . '/../Fixtures/restaurants.json'));
        $request = new Request();
        $request->parameters = ['keyword' => 'Restaurant 1'];
        $response = $this->restaurantController->search($request);
        $this->assertEquals("[{\"name\":\"Restaurant 1\",\"status\":\"open\",\"features\":[{\"code\":\"status\",\"value\":2},{\"code\":\"feature_1\",\"value\":1},{\"code\":\"feature_2\",\"value\":999999}]}]", $response->content);
        $this->assertEquals(200, $response->code);
    }

    function test_search_case_sorty_by_feature()
    {
        $this->dataAccessMock->method("read")->willReturn(file_get_contents(__DIR__ . '/../Fixtures/restaurants.json'));
        $request = new Request();
        $request->parameters = ['sortby' => 'feature_1'];
        $response = $this->restaurantController->search($request);
        $this->assertEquals("[{\"name\":\"Restaurant 1\",\"status\":\"open\",\"features\":[{\"code\":\"status\",\"value\":2},{\"code\":\"feature_1\",\"value\":1},{\"code\":\"feature_2\",\"value\":999999}]},{\"name\":\"Restaurant 2\",\"status\":\"closed\",\"features\":[{\"code\":\"status\",\"value\":0},{\"code\":\"feature_1\",\"value\":2},{\"code\":\"feature_2\",\"value\":0.07}]}]", $response->content);
        $this->assertEquals(200, $response->code);
    }

}