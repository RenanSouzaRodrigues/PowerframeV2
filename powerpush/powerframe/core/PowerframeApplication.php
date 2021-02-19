<?php 

namespace powerpush\powerframe\core;

use Dotenv\Dotenv;
use \powerpush\powerframe\core\Router;
use \powerpush\powerframe\core\Cors;
use \powerpush\powerframe\core\Response;
use \powerpush\powerframe\core\Request;
use \powerpush\powerframe\core\exceptions\InvalidRequestMethodException;

class PowerframeApplication {
    public Cors $cors;
    public Request $request;
    public Response $response;
    public Router $router;

    private $environment;

    public function __construct() {
        $this->request = new Request();
        $this->response = new Response();
        $this->cors = new Cors();
        $this->router = new Router();
    }

    public function loadEnv(String $envFile = null) {
        if(is_null($envFile)) {
            $dotenv = Dotenv::createImmutable(__DIR__);
            $dotenv->load();
            $this->environment = $_ENV;
        } else {
            $dotenv = Dotenv::createImmutable(__DIR__, $envFile);
            $dotenv->load();
            $this->environment = $_ENV;
        }
    }

    public function env($envName) {
        return $this->environment[$envName];
    }

    public function get($path, $callback) {
        $this->router->get($path, $callback);
    }

    public function put($path, $callback) {
        $this->router->put($path, $callback);
    }

    public function patch($path, $callback) {
        $this->router->patch($path, $callback);
    }

    public function post($path, $callback) {
        $this->router->post($path, $callback);
    }

    public function delete($path, $callback) {
        $this->router->delete($path, $callback);
    }

    public function options($path, $callback) {
        $this->router->options($path, $callback);
    }

    public function run() {
        try {
            $this->router->createAndValidateRoutes();
            $this->request->setHeaders($this->router->getRequestHeaders());
            $this->request->setBody($this->router->getRequestBody);
        } catch (InvalidRequestMethodException $e) {
            $this->response->status($e->getResponseStatus())->json(['error'=> $e->getMessage()]);
        } catch (\Exception $e) {
            $this->response->status(500)->json(['error' => $e->getMessage()]);
        }
    }
}

?>