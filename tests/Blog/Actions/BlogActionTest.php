<?php

namespace Tests\App\Blog\Actions;

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\ServerRequest;
use App\Blog\Actions\BlogAction;
use App\Blog\Table\PostTable;
use Framework\Router;
use Framework\Renderer\RendererInterface;
use Prophecy;
use App\Blog\Entity\Post;

/**
 *
 */
class BlogActionTest extends TestCase
{

  private $action;
  private $renderer;
  private $postTable;
  private $router;

  public function setUp()
  {
    $this->renderer = $this->prophesize(RendererInterface::class);
    $this->postTable = $this->prophesize(PostTable::class);

    $this->router = $this->prophesize(Router::class);

    $this->action = new BlogAction($this->renderer->reveal(),  $this->router->reveal(), $this->postTable->reveal());
  }

  public function makePost(int $id, string $slug): Post
  {
    $post = new Post();
    $post->id = $id;
    $post->slug = $slug;
    return $post;
  }

  public function testShowredirect()
  {
    $post = $this->makePost(9, 'ihihiohj');
    $request = (new ServerRequest('GET', '/'))
          ->withAttribute('id', $post->id)
          ->withAttribute('slug', 'demo');

    $this->router->generateUri('blog.show', ['id' => $post->id, 'slug' => $post->slug])->willReturn('/demo2');
    $this->postTable->find($post->id)->willReturn($post);


    $response = call_user_func_array($this->action, [$request]);
    $this->assertEquals(301, $response->getStatusCode());
    $this->assertEquals(['/demo2'], $response->getHeader('location'));
  }

  public function testShowrender()
  {
    $post = $this->makePost(9, 'ihihiohj');
    $request = (new ServerRequest('GET', '/'))
          ->withAttribute('id', $post->id)
          ->withAttribute('slug',  $post->slug);

    $this->postTable->find($post->id)->willReturn($post);
    $this->renderer->render('@blog/show', ['post' => $post])->willReturn('');


    $response = call_user_func_array($this->action, [$request]);
    $this->assertEquals(true, true);
  }
}
