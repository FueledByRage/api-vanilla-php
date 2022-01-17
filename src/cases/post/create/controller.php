<?php
require_once './cases/post/create/create.php';
require_once './entities/post.php';
require_once './utils/checkKeys.php';

class CreatePostController{

    function __construct(
        public CreatePost $create,
        public CheckKeys $checkKeys
    ){}

    function execute($req, $res, $jwt){
        try{
            $body = $req->body();
            var_dump($body);
            if(!$this->checkKeys->execute($body, ['body', 'token'])) throw new Exception('Missing credentials', 406);    
            $user = $jwt->decript($body['token'])->{'username'};
            $post = new Post($user, $body['body'], date('Y-m-d H:i:s'));
            $this->create->save($post);
            die();
        }catch(Exception $e){
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    
    }
}