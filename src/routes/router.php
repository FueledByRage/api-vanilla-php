<?php
require_once './providers/database/bd.php';
require_once './http/request.php';
require_once './http/response.php';
require_once './entities/user.php';
require_once './repositories/implementations/userMysqlImplementation.php';
require_once './repositories/implementations/postMysqlImplementation.php';
require_once './routes/urlHandler.php';

class Router{
    public $routes = [];

    function __construct(
        private URLHandler $urlHandler,
    ){}
    
    public function GET($path, $controller){
        $this->routes['GET'][$path] = $controller;    
    }
    
    public function POST($path, $controller){
        $this->routes['POST'][$path] = $controller;    
    }
    
    function routeHandler($explodedURL, $method){
        if($explodedURL[1] == 'api'){
            try{
                $req = new Request;
                $res = new Response;
                $jwt = new JWT();

                $explodedURL = $this->urlHandler->removeBlank($explodedURL);
                $explodedURL = $this->urlHandler->removeApi($explodedURL);
                $url = $this->urlHandler->getRoute($explodedURL);


                !array_key_exists($url, $this->routes[$method]) ? throw new Exception("Route not found", 404) : 

                $this->routes[strtoupper($method)][$url]->execute($req, $res, $jwt);
            }catch(Exception $e){
                http_response_code($e->getCode());
                echo json_encode(['error' =>$e->getMessage()]);
            }
        }else{
            http_response_code(400);
            echo json_encode(['error' => 'Router not found']);
        }
    }
}