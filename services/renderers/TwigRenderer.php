<?php


namespace app\services\renderers;


use app\interfaces\RenderInterface;

class TwigRenderer implements RenderInterface
{
    public function render($template, $params = [])
    {
        $loader = new Twig_Loader_Filesystem(VIEWS_DIR);
        $twig = new Twig_Environment($loader);
        $template = $twig->loadTemplate($template . ".php");
        echo $template->render($params);
    }
}