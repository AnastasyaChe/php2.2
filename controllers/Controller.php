<?php


namespace app\controllers;


use app\exceptions\NotFoundException;
use app\interfaces\RenderInterface;

abstract class Controller
{
    protected $defaultAction = 'index';
    protected $action;
    protected $useLayout = true;
    protected $layout = 'main';
    protected $renderer;

    
    public function __construct(RenderInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function runAction($action = null)
    {
        $this->action = $action ?: $this->defaultAction;
        $method = "action" . ucfirst($this->action);

        if(method_exists($this, $method)) {
            $this->$method();
        } else {
            throw new NotFoundException("Метод не найден");
        }
    }

    protected function render($template, $params = []) {
        $content = $this->renderer->render($template, $params);
        if($this->useLayout) {
            return $this->renderer->render(
                "layouts/{$this->layout}",
                ['content' => $content]
            );
        }
        return $content;
    }
}