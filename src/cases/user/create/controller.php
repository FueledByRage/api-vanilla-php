<?php
require_once './cases/user/create/create.php';
require_once './entities/user.php';
require_once './utils/checkKeys.php';
require_once './providers/jwt/jwt.php';

class Controller{

    function __construct(
        public CreateUser $create,
        public CheckKeys $checkKeys,
        public JWT $jwt,
    ){}

    function execute($req, $res){
        try{
            $body = $req->body();
            if(!$this->checkKeys->execute($body, ['username', 'email', 'password', 'about'])){
                throw new Exception('Missing credentials', 406);
            }

            $user = new User($body['username'], $body['email'], $body['password'], $body['about']);
            
            $save = $this->create->save($user);
            
            if(!$save) throw new Exception('Error saving user', 500);

            $token = $this->jwt->provider(['typ' => 'JWT', 'alg' => 'HS256'],['username' => $user->username]);
            $res->send(['token' => $token, 'user' => $user->username]);
        }catch(Exception $e){
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    }
}