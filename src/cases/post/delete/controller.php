<?php
require_once './providers/jwt/jwt.php';
require_once './cases/post/delete/delete.php';
require_once './entities/post.php';
require_once './utils/checkKeys.php';

class DeleteController{

    function  __construct(
        public DeletePost $delete,
        public JWT $jwt,
        public CheckKeys $checkKeys,
    ){}

    function execute($req, $res){
        try{
            $token = getallheaders()['token'];
            

            if(!$this->checkKeys->execute($req->params, ['id']) || !$token) throw new Exception('Missing credentials', 406);    
    
            $username = $this->jwt->decript($token)->{'username'};
    
            $deleted = $this->delete->execute($req->params['id'], $username);
            
            die();
            
        }catch(\Throwable $e){
            $res->status(500);
            $res->send(['message' => $e->getMessage()]);
        }
    }
}