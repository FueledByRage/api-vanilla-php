<?php
require_once './cases/user/create/create.php';
require_once './entities/user.php';
require_once './utils/checkKeys.php';

class Controller{

    function __construct(
        public CreateUser $create,
        public CheckKeys $checkKeys
    ){}

    function execute($req, $res, $jwt){
        try{
            $body = $req->body();
            if(!$checkKeys->execute($body, ['username', 'email', 'password', 'about'])){
                throw new Exception('Missing credentials', 406);
            }
            $user = new User($body['username'], $body['email'], $body['password'], $body['about']);
            $token = $jwt->provider(['typ' => 'JWT', 'alg' => 'HS256'],['username' => $user['username']]);
            $res->send(['token' => $token, 'user' => $user['username']]);
        }catch(Exception $e){
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    }
}