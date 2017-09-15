<?php
namespace Tests\Framework;

use Framework\App;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\ServerRequest;
use App\Blog\BlogModule;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;
/**
 *
 */
class AppTest extends TestCase
{

  public function testRedirectTrainingSlash()
  {
    $app = new App([]);
    $request = new ServerRequest('GET','/demoSlash/');
    $response = $app->run($request);
    $this->assertContains('/demoSlash', $response->getHeader('Location'));
    $this->assertEquals('301', $response->getStatusCode());
  }

  public function testBlog()
  {
    $app = new App([
      BlogModule::class
    ]);
    $request = new ServerRequest('GET','/blog');
    $response = $app->run($request);
    $this->assertContains('<h1>Bienvenue sur le blog</h1>', (string) $response->getBody());
    $this->assertEquals('200', $response->getStatusCode());

    $requestSingle = new ServerRequest('GET','/blog/article-de-test');
    $responseSingle = $app->run($requestSingle);
    $this->assertContains('<h1>Bienvenue sur l\'article :article-de-test</h1>', (string) $responseSingle->getBody());
  }

  public function testThrowExecptionIfNotResponseSend()
  {
    $app = new App([
      ErroredModule::class
    ]);
    $request = new ServerRequest('GET','/demo');
    $this->expectException(\Exception::class);
    $app->run($request);
  }

  public function testConvertStringToResponseResponseSend()
  {
    $app = new App([
      StringModule::class
    ]);
    $request = new ServerRequest('GET','/demo');
    $response = $app->run($request);
    $this->assertInstanceOf(ResponseInterface::class, $response);
    $this->assertContains('DEMO', (string) $response->getBody());
  }

  public function testError4040()
  {
    $app = new App([]);
    $request = new ServerRequest('GET','/ioho');
    $response = $app->run($request);
    $this->assertContains('<h1>Erreur 404</h1>', (string) $response->getBody());
    $this->assertEquals('404', $response->getStatusCode());
  }

}
