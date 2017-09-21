<?php

namespace Framework\Renderer;

/**
 *
 */
class TwigRenderer implements RendererInterface
{
    const DEFAULT_NAMESPACE = '__MAIN';

    private $twig;
    private $loader;

    public function __construct(?string $defaultPath = null)
    {
        $this->loader = new \Twig_Loader_Filesystem($defaultPath);
        $this->twig = new \Twig_Environment($this->loader, []);
    }

    public function addPath(string $namespace, ?string $path = null): void
    {
        $this->loader->addPath($path, $namespace);
    }

    public function addGlobal(string $key, $value): void
    {
        $this->twig->addGlobal($key, $value);
    }

    public function render(string $view, array $params = []): string
    {
        return $this->twig->render($view . '.twig', $params);
    }
}
