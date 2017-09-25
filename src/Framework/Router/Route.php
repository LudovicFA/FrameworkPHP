<?php

namespace Framework\Router;

/**
 * Class Route
 */
class Route
{

    private $name;
    private $callback;
    private $parameters;

    public function __construct(string $name, $callback, array $parameters)
    {
        $this->name = $name;
        $this->callback = $callback;
        $this->parameters = $parameters;
    }

  /**
   * @return string
   */
    public function getName(): string
    {
        return $this->name;
    }

  /**
   * @return string | callable
   */
    public function getCallback()
    {
        return $this->callback;
    }

  /**
   * @return array
   */
    public function getParams(): array
    {
        return $this->parameters;
    }
}
