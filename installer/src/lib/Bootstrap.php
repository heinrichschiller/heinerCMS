<?php
class Bootstrap
{
    private $_controller = '';
    private $_action = '';
    private $params = [];
    
    public function __construct()
    {
        $this->_parseRequest();
    }

    private function _parseRequest()
    {
        $path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        @list($controller, $action, $params) = explode('/', $path, 3);
        // controller
        $controller = (strlen($controller) > 0) ? $controller : 'index';
        $this->_setController($controller);
        // action
        $action = (strlen($action) > 0) ? $action : 'index';
        $this->_setAction($action);
        // params
        if(isset($params)) {
            $this->_setParams($params);
        }
    }

    private function _setController($controller)
    {
        $ctrl = sprintf("\\Controller\\%sController", ucfirst(strtolower($controller)));
        $this->_controller = $ctrl;
        if(!class_exists($this->_controller)) {
            throw new InvalidArgumentException(
                "Controller unbekannt: $ctrl"
            );
        }
    }

    private function _setAction($action)
    {
        $actionMethod = sprintf("%sAction", strtolower($action));
        $reflection = new ReflectionClass($this->_controller);
        if(!$reflection->hasMethod($actionMethod)) {
            throw new InvalidArgumentException(
                "$this->controller hat keine Action: $action"
            );
        }
        $this->_action = $actionMethod;
    }

    private function _setParams($params)
    {
        $splitted = explode('/', $params);
        if(count($splitted) % 2 > 0) {
            throw new InvalidArgumentException("Parameterzahl ungültig");
        }
        $paramArray = [];
        $lastIndex = 0;
        for($i = 0; $i < count($splitted); $i++) {
            if($i % 2 > 0) {
                $paramArray[$splitted[$lastIndex]] = $splitted[$i];
            }
            $lastIndex = $i;
        }
        $this->_params = $paramArray;
    }

    public function run()
    {
        $ctrlObj = new $this->_controller;
        $ctrlObj->{$this->_action}($this->_params);
    }
}
