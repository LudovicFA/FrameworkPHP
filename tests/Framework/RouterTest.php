<?php

namespace Tests\Framework;

use Framework\App;
use Framework\Router;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\ServerRequest;

/**
 *
 */
class RouterTest extends TestCase
{
      private $router;

      public function setUp()
      {
          $this->router = new Router();
      }

      public function testGetMethod()
      {
            $request = new ServerRequest('GET','/blog');
            $this->router->get('/blog', function() {return 'hello';}, 'blog');
            $route = $this->router->match($request);
            $this->assertEquals('blog', $route->getName());
            $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
      }

      public function testGetMethodIfURLDoesNotExist()
      {
            $request = new ServerRequest('GET','/blog');
            $this->router->get('/blogdzadaz', function() {return 'hello';}, 'blog');
            $route = $this->router->match($request);
            $this->assertEquals(null, $route);
      }


      public function testGetMethodWithParameters()
      {
            $request = new ServerRequest('GET','/blog/mon-slug-8');
            $this->router->get('/blog', function() {return 'azeaea';}, 'posts');
            $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function() {return 'hello';}, 'post.show');
            $route = $this->router->match($request);
            $this->assertEquals('post.show', $route->getName());
            $this->assertEquals('hello', call_user_func_array($route->getCallback(), [$request]));
            $this->assertEquals(['slug' => 'mon-slug', 'id' => '8'], $route->getParams());
            // Test invalid Und
            $route = $this->router->match(new ServerRequest('GET','/blog/mon_slug-8'));
            $this->assertEquals(null, $route);
      }

    public function testGenerateUri()
      {
            $this->router->get('/blog', function() {return 'azeaea';}, 'post');
            $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function() {return 'hello';}, 'post.show');
            $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => '18']);
            $this->assertEquals('/blog/mon-article-18', $uri);

      }

    public function testGenerateUriWithQueryPArams()
      {
            $this->router->get('/blog', function() {return 'azeaea';}, 'post');
            $this->router->get('/blog/{slug:[a-z0-9\-]+}-{id:\d+}', function() {return 'hello';}, 'post.show');
            $uri = $this->router->generateUri('post.show', ['slug' => 'mon-article', 'id' => '18'], ['p'=>2]);
            $this->assertEquals('/blog/mon-article-18?p=2', $uri);

      }
}
