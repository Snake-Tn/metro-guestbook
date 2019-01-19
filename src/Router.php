<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

use Controller\EntryController;
use Controller\AuthorizationController;

class Router
{

    const CONFIGURATION_MAP = [
        'POST/api/entries' => ['controller' => EntryController::class, 'method' => 'create'],
        'POST/api/auth' => ['controller' => AuthorizationController::class, 'method' => 'login'],

    ];
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function route(Http\Request $request): Http\Response
    {
        try {
            $routeAction = $this->resolve($request);
            return $this->container->getInstance($routeAction['controller'])->{$routeAction['method']}($request);
        } catch (\Exception\NotFoundException $e) {
            return new \Http\Response(json_encode(['error' => $e->getMessage()]), Http\Response::JSON_CONTENT_TYPE, Http\Response::NOT_FOUND);
        } catch (\Exception\BadRequestException $e) {
            return new \Http\Response(json_encode(['error' => $e->getMessage()]), Http\Response::JSON_CONTENT_TYPE, Http\Response::BAD_REQUEST);
        } catch (\Exception\ForbiddenException $e) {
            return new \Http\Response(json_encode(['error' => $e->getMessage()]), Http\Response::JSON_CONTENT_TYPE, Http\Response::INVALID_USERNAME_OR_PASSWORD);
        } catch (\Exception $e) {
            return new \Http\Response(json_encode(['error' => $e->getMessage()]), Http\Response::JSON_CONTENT_TYPE, Http\Response::INTERNAL_SERVER_ERROR);
        }
    }


    private function resolve(Http\Request $request): array
    {
        foreach (self::CONFIGURATION_MAP as $routeCondition => $routeAction) {
            if ($routeCondition === $request->getMethod() . $request->getUrlPath()) {
                return $routeAction;
            }
        }
        throw new Exception("Router could not find an appropriate handler.");
    }
}