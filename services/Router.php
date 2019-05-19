<?php


namespace app\services;



use app\controllers\GalleryController;

class Router
{

    private $controller;
    private $action;

    private $requestString;
    private $controllerName;
    private $actionName;
    private $params;
    private $method;

    public function __construct()
    {
        $this->requestString = $_SERVER['REQUEST_URI'];
        $this->parseRequest();

    }

    private function parseRequest()
    {
        $pattern = "#(?P<controller>[a-z]+)[/]?(?P<action>\w+)?[/]?[?]?(?P<params>.*)#ui";
        $this->method = $_SERVER['REQUEST_METHOD'];
        if (preg_match_all($pattern, $this->requestString, $matches)) {
            $this->controllerName = strip_tags($matches['controller'][0]);
            $this->actionName = strip_tags($matches['action'][0]);
            $this->params = $_REQUEST;

        }
    }



    public function runController()
    {
        $this->controller = $this->controllerName ?: 'product';
        $this->action = $this->actionName;

        $controllerClass = CONTROLLERS_NAMESPACE . ucfirst($this->controller) . "Controller";

        if (!class_exists($controllerClass)) {
            $controllerClass = GalleryController::class;
        }
        $controller = new $controllerClass(new TemplateRenderer());
        $controller->runAction($this->action);
    }
}