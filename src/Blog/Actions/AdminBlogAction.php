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
class AdminBlogAction
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
        if ($request->getMethod() === 'DELETE') {
            return $this->delete($request);
            ;
        }
        if (substr((string)$request->getUri(), -3) === 'new') {
            return $this->create($request);
        }
        if ($request->getAttribute('id')) {
            return $this->edit($request);
        } else {
            return $this->index($request);
        }
    }
    public function index(Request $request): string
    {
        $params = $request->getQueryParams();
        $items = $this->postTable->findPaginated(12, $params['p'] ?? 1);
        return $this->renderer->render('@blog/admin/index', compact('items'));
    }

    public function edit(Request $request)
    {
        $item = $this->postTable->find($request->getAttribute('id'));

        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params = array_merge($params, [
            'updated_at' => date('Y-m-d H:i:s')
            ]);
            $this->postTable->update($item->id, $params);
            return $this->redirect('blog.admin.index');
        }

        return $this->renderer->render('@blog/admin/edit', compact('item'));
    }

    public function create(Request $request)
    {

        if ($request->getMethod() === 'POST') {
            $params = $this->getParams($request);
            $params = array_merge($params, [
            'updated_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s')
            ]);
            $this->postTable->insert($params);
            return $this->redirect('blog.admin.index');
        }

        return $this->renderer->render('@blog/admin/create');
    }

    public function delete(Request $request)
    {
        $this->postTable->delete($request->getAttribute('id'));
        return $this->redirect('blog.admin.index');
    }

    private function getParams(Request $request)
    {
        return array_filter($request->getParsedBody(), function ($key) {
            return in_array($key, ['name', 'content', 'slug']);
        }, ARRAY_FILTER_USE_KEY);
    }
}
