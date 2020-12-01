<?php


namespace app\services\renderers;


use app\interfaces\RenderInterface;

class TwigRenderer implements RenderInterface
{
    public function render($template, $params = [])
    {
        $loader = new Twig\Loader\FilesystemLoader(VIEWS_DIR . "twig");
        $twig = new Twig\Environment($loader, []);
        $template .= ".twig";
        return $twig->render($template, $params);
    }
}