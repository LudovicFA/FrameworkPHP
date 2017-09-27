<?php
namespace Framework\Actions;

use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Psr7\Response;

/**
 * Rajoute des méthode liées à l'utilisation du router
 */
trait RouterAwareAction
{

  /* Renvoi une reponse de redirection */
    public function redirect(string $path, array $params = []): ResponseInterface
    {
        $redirectUri = $this->router->generateUri($path, $params);
        return (new Response())
        ->withStatus(301)
        ->withHeader('location', $redirectUri);
    }
}
