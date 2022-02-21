<?php
require_once './entities/user.php';
require 'login.php';
require_once './utils/checkKeys.php';

class loginController{
    function __construct(
        public Login $login,
        public CheckKeys $checkKeys
    ){}

    function execute($req, $res, $jwt){
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

            $token = $jwt->provider(['typ' => 'JWT', 'alg' => 'HS256'],['username' => $user['username']]);
            $res->status(200);
            $res->send(['token' => $token,'username' => $user['username']]);
        }catch(\Throwable $e){
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    }
}