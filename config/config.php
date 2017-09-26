<?php

use \Framework\Renderer\RendererInterface;
use \Framework\Renderer\TwigRenderer;
use \Framework\Renderer\TwigRendererFactory;
use \Framework\Router\RouterTwigExtension;


return [
  'database.host' => 'localhost',
  'database.user' => 'root',
  'database.password' => '',
  'database.name' => 'monsupersite',
  'view.path' => dirname(__DIR__).'/views',
  'twig.extensions' => [
    \DI\get(RouterTwigExtension::class)
  ],
  RendererInterface::class => \DI\factory(TwigRendererFactory::class),
  \Framework\Router::class => \DI\object()
];
