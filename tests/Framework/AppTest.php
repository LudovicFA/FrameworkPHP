<?php
namespace Tests\Framework;

use Framework\App;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;
/**
 *
 */
class AppTest extends TestCase
{

  public function testRedirectTrainingSlash()
  {
    $app = new App();
    $request = new ServerRequest('GET','/demoSlash/');
    $response = $app->run($request);
    $this->assertContains('/demoSlash', $response->getHeader('Location'));
    $this->assertEquals('301', $response->getStatusCode());
  }

  public function testBlog()
  {
    $app = new App();
    $request = new ServerRequest('GET','/blog');
    $response = $app->run($request);
    $this->assertContains('<h1>Bienvenue sur le blog</h1>', (string) $response->getBody());
    $this->assertEquals('200', $response->getStatusCode());
  }

  public function testError4040()
  {
    $app = new App();
    $request = new ServerRequest('GET','/ioho');
    $response = $app->run($request);
    $this->assertContains('<h1>Erreur 404</h1>', (string) $response->getBody());
    $this->assertEquals('404', $response->getStatusCode());
  }

}
