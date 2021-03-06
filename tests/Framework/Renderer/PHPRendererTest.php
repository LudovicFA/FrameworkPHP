<?php
namespace Tests\Framework;

use Framework\App;
use Framework\Renderer;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\ServerRequest;
use App\Blog\BlogModule;
use Tests\Framework\Modules\ErroredModule;
use Tests\Framework\Modules\StringModule;
/**
 *
 */
class PHPRendererTest extends TestCase
{

  private $renderer;

  public function setUp()
  {
      $this->renderer = new Renderer\PHPRenderer(__DIR__ . '/views');
  }

  public function testRenderTheRightPath()
  {
    $this->renderer->addPath('blog', __DIR__ . '/views');
    $content = $this->renderer->render('@blog/demo');
    $this->assertEquals('Salut les gens!!
', $content);
  }

  public function testRenderTheDefaultPath()
  {
    $content = $this->renderer->render('demo');
    $this->assertEquals('Salut les gens!!
', $content);
  }

  public function testRenderWithParams()
  {
    $content = $this->renderer->render('demoparams', ['nom' => "Marc"]);
    $this->assertEquals('Salut Marc', $content);
  }

  public function testGlobalsParams()
  {
    $this->renderer->addGlobal('nom', 'Marc');
    $content = $this->renderer->render('demoparams');
    $this->assertEquals('Salut Marc', $content);
  }

}
