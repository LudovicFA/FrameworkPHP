<?php
namespace Framework;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use GuzzleHttp\Psr7\Response;
use Framework\Router;

class App
{
    private $modules = [];
    private $router;

    /**
    * App constructopr
    * @param string[] $modules List of modules
    */

    public function __construct(array $modules = [])
    {
        $this->router = new Router();
        foreach ($modules as $module) {
          $this->modules[] = new $module($this->router);
        }
    }

    public function run(ServerRequestInterface $request): ResponseInterface
    {
        $uri = $request->getUri()->getPath();
        if (!empty($uri) && $uri[-1] === "/") {
            return (new Response())
                                    ->withStatus(301)
                                    ->withHeader('Location', substr($uri, 0, -1));
        }
        $route = $this->router->match($request);
        if(is_null($route)){
          return new Response(404, [], '<h1>Erreur 404</h1>');
        }
        $params = $route->getParams();
        $request = array_reduce(array_keys($params), function ($request, $key) use ($params) {
          return $request->withAttribute($key, $params[$key]);
        }, $request);

        $response = call_user_func_array($route->getCallback(), [$request]);
        if(is_string($response)){
          return new Response(200, [], $response);
        }
        elseif ($response instanceof ResponseInterface) {
          return $response;

        }
        else{
          throw new \Exception("The response is not a string or an instanceof ResponseInterface", 1);

        }
    }
}
