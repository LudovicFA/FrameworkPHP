<?php
namespace App\Blog;

use Framework\Router;
use Framework\Module;
use Framework\Renderer\RendererInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use App\Blog\Actions\BlogAction;

/**
 *
 */
class BlogModule extends Module
{
    private $renderer;
    const DEFINITIONS = __DIR__ . '/config.php';
    const MIGRATIONS = __DIR__ . '/db/migrations';
    const SEEDS = __DIR__ . '/db/seeds';

    public function __construct(string $prefix, Router $router, RendererInterface $renderer)
    {
        $renderer->addPath('blog', __DIR__ . '/views');

        $router->get($prefix, BlogAction::class, 'blog.index');
        $router->get($prefix.'/{slug:[a-z\-0-9\-]+}-{id:[0-9]+}', BlogAction::class, 'blog.show');
    }
}
