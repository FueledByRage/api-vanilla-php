<?php
require_once './entities/user.php';
require 'login.php';
require_once './utils/checkKeys.php';
require_once './providers/jwt/jwt.php';


class loginController{
    function __construct(
        public Login $login,
        public CheckKeys $checkKeys,
        public JWT $jwt
    ){}

    function execute($req, $res){
        try{
            $body = $req->body();

            if(!$this->checkKeys->execute($body, ['password', 'email'])){
                $res->status(406);
                $res->send(['message' => 'Missing param.']);
            }
            $user = $this->login->execute(
                $body['email'],
                $body['password'],
            );

            $token = $this->jwt->provider(['typ' => 'JWT', 'alg' => 'HS256'],['username' => $user['username']]);
            $res->status(200);
            $res->send(['token' => $token,'username' => $user['username']]);
        }catch(\Throwable $e){
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    }
}