<?php

define('ROOTPATH', __DIR__);

require __DIR__.'/controllers/ValidationController.php';


$params = explode('/', $_SERVER['QUERY_STRING']);

try {
    if (is_array($params) && isset($params[0], $params[1])) {
        $controllerClassName = $_SERVER['HTTP_HOST']. '\controllers\\' . ucwords($params[0]) . 'Controller';
        $action = ucwords(str_replace('-', ' ', $params[1]));
        $actionName = 'action' . str_replace(' ', '', $action);

        $controller = new $controllerClassName ();
        $result = $controller->$actionName();

        header("HTTP/1.1 200 OK");
        print  json_encode($result);
    }
} catch (\Error $e) {
    header("HTTP/1.1 404 Not found");
    print 'Page is not found.';
}
