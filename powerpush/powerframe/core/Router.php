<?php 

namespace powerpush\powerframe\core;

use \powerpush\powerframe\core\exceptions\InvalidRequestMethodException;
use \powerpush\powerframe\core\exceptions\RouteNotFoundException;

class Router {
    protected array $routes = []; 
    private $headers;
    private $body;
    private $params;
    private $query;

    public function get($route, $callback) {
        $this->setRoute('GET', $route, $callback);
    }

    public function post($route, $callback) {
        $this->setRoute('POST', $route, $callback);
    }

    public function put($route, $callback) {
        $this->setRoute('PUT', $route, $callback);
    }

    public function delete($route, $callback) {
        $this->setRoute('DELETE', $route, $callback);
    }

    public function patch($route, $callback) {
        $this->setRoute('PATCH', $route, $callback);
    }

    public function options($route, $callback) {
        $this->setRoute('OPTIONS', $route, $callback);
    }

    private function setRoute($method, $route, $callback) {
        $this->routes[count($this->routes)] = [
            'route' => $route,
            'method' => $method,
            'function' => $callback,
        ];
    }

    public function getRoutes() {
        return $this->routes;
    }

    public function createAndValidateRoutes() {
        $receivedURL = $_SERVER['REQUEST_URI'];
        $treatedUrl = explode('?', $receivedURL);
        $method = $_SERVER['REQUEST_METHOD'];

        $foundedRoute = false;
        $foundedMethod = false;
        $callback = null;
        for ($index = 0; $index < count($this->routes); $index++) {
            if($treatedUrl[0] == $this->routes[$index]['route']) {
                $foundedRoute = true;
                
                if($method != $this->routes[$index]['method']) {
                   $foundedMethod = false;
                } else {
                    $foundedMethod = true;
                    $callback = $this->routes[$index]['function'];
                    break;
                }
            }
        }

        // var_dump($this->routes);exit;

        if(!$foundedRoute) throw new RouteNotFoundException("Route '{$receivedURL}' not found or not created.") ;
        if(!$foundedMethod) throw new InvalidRequestMethodException("Error processing request, Method {$method} not allowed for route '{$receivedURL}'.") ;
        
        $this->setRequestQuery($receivedURL);
        $this->setRequestBody(file_get_contents("php://input"));

        call_user_func($callback);

    }

    private function setRequestQuery($url) {
        if(preg_match('/\?/', $url)) {
            $arrayParams = explode('?', $url);
            if($arrayParams[1] != '') {
                if(preg_match('/\&/', $arrayParams[1])) {
                    $arrayParams = explode('&',$arrayParams[1]);
                    $paramsList = [];
                    foreach($arrayParams as $param) {
                        $auxParams = explode('=', $param);
                        array_push($paramsList, [$auxParams[0] => $auxParams[1]]);
                    }
                    $this->params = (object) $paramsList;
                }
            } 
        }
    }

    public function getRequestQuery() {
        return $this->query;
    }

    private function setRequestBody($body) {
        $requestBody = trim($body);
        $this->body = json_decode($requestBody);
    }

    public function getRequestBody() {
        return $this->body;
    }

    private function setRequestParams() {

    }

    public function getRequestParams() {
        return $this->param;
    }

    private function setRequestHeaders() {
        
    }

    public function getRequestHeaders() {
        return $this->headers;
    }

}

?>