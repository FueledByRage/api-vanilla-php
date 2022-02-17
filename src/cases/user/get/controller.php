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
                throw new Exception('Missing credentials', 406);
            }
            $user = $this->getUser->get($username);
            $res->send($user);
        }catch(Exception $e){  
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    }
}