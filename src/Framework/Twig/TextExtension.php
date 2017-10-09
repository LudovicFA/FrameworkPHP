<?php
namespace Framework\Twig;

use Framework\Router;

/**
 * Serie d'extension concernnat les textes
 */
class TextExtension extends \Twig_Extension
{



    public function getFilters(): array
    {
        return [
        new \Twig_SimpleFilter('excerpt', [$this, 'excerpt'])
        ];
    }

    public function excerpt(string $content, int $maxlenth = 100): string
    {
        if (mb_strlen($content) > $maxlenth) {
            $excerpt = mb_substr($content, 0, $maxlenth);
            $lastspace = mb_strrpos($excerpt, ' ');
            return  mb_substr($excerpt, 0, $lastspace) . '...';
        }
        return $content;
    }
}
