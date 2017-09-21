<?php

namespace Framework\Renderer;

/**
 *
 */
interface RendererInterface
{
    public function addPath(string $namespace, ?string $path = null): void;

    public function addGlobal(string $key, $value): void;

    public function render(string $view, array $params = []): string;
}
