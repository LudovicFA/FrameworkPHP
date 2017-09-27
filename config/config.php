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
  \Framework\Router::class => \DI\object(),
  \PDO::class => function(\Psr\Container\ContainerInterface $container){
      return  new \PDO(
        'mysql:host='.$container->get('database.host').';dbname='.$container->get('database.name'),
        $container->get('database.user'),
        $container->get('database.password'),
        [
          \PDO::ATTR_DEFAULT_FETCH_MODE =>\PDO::FETCH_OBJ,
          \PDO::ATTR_ERRMODE =>\PDO::ERRMODE_EXCEPTION
        ]
      );
  }
];
