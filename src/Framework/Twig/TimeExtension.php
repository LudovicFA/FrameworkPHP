<?php
namespace Framework\Twig;

use Framework\Router;

/**
 * Serie d'extension concernnat les textes
 */
class TimeExtension extends \Twig_Extension
{



    public function getFilters(): array
    {
        return [
        new \Twig_SimpleFilter('ago', [$this, 'ago'], ['is_safe'=>['html']])
        ];
    }

    public function ago(\Datetime $date, string $format = 'd/m/Y H:i'): string
    {
        return '<span class="timeago" datetime="'. $date->format(\Datetime::ISO8601) .'">'.
          $date->format($format).
          '</span>';
    }
}
