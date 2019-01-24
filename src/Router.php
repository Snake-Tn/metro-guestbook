<?php

/**
 * Copyright © 2019 Ahmed Kooli. metro-guestbook challenge.
 */

declare(strict_types=1);

use Controller\EntryController;
use Controller\AuthorizationController;
use Controller\IndexController;

class Router
{

    const CONFIGURATION_MAP = [
        'POST/api/entries' => ['controller' => EntryController::class, 'method' => 'create'],
        'POST/api/entries/([1-9]+)/is_approved' => ['controller' => EntryController::class, 'method' => 'approve'],
        'PUT/api/entries/([1-9]+)' => ['controller' => EntryController::class, 'method' => 'update'],
        'DELETE/api/entries/([1-9]+)' => ['controller' => EntryController::class, 'method' => 'delete'],
        'GET/api/entries' => ['controller' => EntryController::class, 'method' => 'list'],
        'GET/api/auth/token' => ['controller' => AuthorizationController::class, 'method' => 'login'],
        'GET/' => ['controller' => IndexController::class, 'method' => 'index'],
        'GET/login' => ['controller' => IndexController::class, 'method' => 'index'],
        'GET/admin' => ['controller' => IndexController::class, 'method' => 'index'],

    ];

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param \Http\Request $request
     * @return \Http\Response
     */
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

    /**
     * @param \Http\Request $request
     * @return string
     * @throws Exception
     */
    private function resolve(Http\Request $request): array
    {
        foreach (self::CONFIGURATION_MAP as $routeCondition => $routeAction) {
            $pattern = '/^' . str_replace('/', '\\/', $routeCondition) . '$/';
            $subject = $request->getMethod() . $request->getUrlPath();
            if (preg_match($pattern, $subject, $matches)) {
                $this->addCapturedParametersToRequest($request, $matches);
                return $routeAction;
            }
        }
        throw new Exception("Router could not find an appropriate handler.");
    }

    /**
     * @param \Http\Request $request
     * @param $matches
     */
    private function addCapturedParametersToRequest(Http\Request $request, $matches): void
    {
        foreach ($matches as $key => $paramValue) {
            if ($key === 0) {
                continue;
            }
            $request->addParameter('param' . $key, $paramValue);
        }
    }
}