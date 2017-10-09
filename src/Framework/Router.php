<?php

namespace Framework;

use Framework\Router\Route;
use Psr\Http\Message\ServerRequestInterface;

use Zend\Expressive\Router\FastRouteRouter;
use Zend\Expressive\Router\Route as ZendRoute;

/**
 * Register and match route
 */
class Router
{
    private $router;

    public function __construct()
    {
        $this->router = new FastRouteRouter();
    }

    public function get(string $path, $callable, string $name)
    {
        $this->router->addRoute(new ZendRoute($path, $callable, ['GET'], $name));
    }

    public function match(ServerRequestInterface $request): ?Route
    {
        $result = $this->router->match($request);
        if ($result->isSuccess()) {
            return new Route(
                $result->getMatchedRouteName(),
                $result->getMatchedMiddleware(),
                $result->getMatchedParams()
            );
        }
        return null;
    }

    public function generateUri(string $name, array $params = [], array $queryParams = []): ?string
    {
        $uri = $this->router->generateUri($name, $params);
        if (!empty($queryParams)) {
            return $uri . '?' . http_build_query($queryParams);
        }
        return $uri;
    }
}
