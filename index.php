<?php

define('ROOTPATH', __DIR__);

require __DIR__.'/controllers/ValidationController.php';

$params = explode('/', $_SERVER['QUERY_STRING']);

try {
    if (is_array($params) && isset($params[0], $params[1])) {
        $controllerClassName = $_SERVER['HTTP_HOST']. '\controllers\\' . ucwords($params[0]) . 'Controller';
        $action = ucwords(str_replace('-', ' ', $params[1]));
        $actionName = 'action' . str_replace(' ', '', $action);

        if (!class_exists($controllerClassName)) {
            throw new Error('Page is not found.', 404);
        }
        $controller = new $controllerClassName ();

        if (!method_exists($controller, $actionName)) {
            throw new Error('Page is not found.', 404);
        }
        $result = $controller->$actionName();

        header("HTTP/1.1 200 OK");
        print  json_encode($result);
    }
} catch (\Error $e) {
    header("HTTP/1.1 500 Error");
    print $e->getMessage(). PHP_EOL;
    print $e->getTraceAsString();
}
