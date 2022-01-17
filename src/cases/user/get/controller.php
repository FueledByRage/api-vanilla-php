<?php
require_once './cases/user/get/get.php';
require_once './entities/user.php';
require_once './utils/checkKeys.php';

class GetController{

    function __construct(
        public GetUser $getUser,
    ){}

    function execute($req, $res, $jwt){
        try{
            $username = array_key_exists('username', $req->params) ? $req->params['username'] : null;
            if($username == null){
                $res->status(406);
                $res->send(['message' => 'Missing credentials']);
            }
            $user = $this->getUser->get($username);
            if($user == null) throw new Exception('User not found', 404);
            $res->send($user);
        }catch(Exception $e){  
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    }
}