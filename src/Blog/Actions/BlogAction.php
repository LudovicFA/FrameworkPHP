<?php

namespace App\Blog\Actions;

use Framework\Router;
use Framework\Actions\RouterAwareAction;
use Framework\Renderer\RendererInterface;
use App\Blog\Table\PostTable;
use Psr\Http\Message\ServerRequestInterface as Request;
use GuzzleHttp\Psr7\Response;

/**
 *
 */
class BlogAction
{
    private $renderer;
    private $router;
    private $postTable;

    use RouterAwareAction;

    public function __construct(RendererInterface $renderer, Router $router, PostTable $postTable)
    {
        $this->renderer = $renderer;
        $this->router = $router;
        $this->postTable = $postTable;
    }


    public function __invoke(Request $request)
    {
        if ($request->getAttribute('id')) {
            return $this->show($request);
        } else {
            return $this->index($request);
        }
    }
    public function index(Request $request): string
    {
        $params = $request->getQueryParams();
        $posts = $this->postTable->findPaginated(12, $params['p'] ?? 1);
        return $this->renderer->render('@blog/index', compact('posts'));
    }

    public function show(Request $request)
    {
        $slug = $request->getAttribute('slug');
        $post = $this->postTable->find($request->getAttribute('id'));
        if ($post->slug !== $slug) {
            return $this->redirect('blog.show', [
            'slug' => $post->slug,
            'id' => $post->id
            ]);
        }
        return $this->renderer->render('@blog/show', [
        'post' => $post
        ]);
    }
}
