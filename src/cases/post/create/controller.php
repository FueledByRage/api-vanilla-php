<?php
require_once './cases/post/create/create.php';
require_once './entities/post.php';
require_once './utils/checkKeys.php';
require_once './providers/jwt/jwt.php';

class CreatePostController{

    function __construct(
        public CreatePost $create,
        public CheckKeys $checkKeys,
        public JWT $jwt
    ){}

    function execute($req, $res){
        try{
            $body = $req->body();

            $token = getallheaders()['token'];

            if(!$this->checkKeys->execute($body, ['body']) || !$token) throw new Exception('Missing credentials', 406);    

            $user = $this->jwt->decript($token)->{'username'};
            
            $file = $req->getFile('file');

            if(!$file) throw new Exception('Vídeo not found.', 406);

            $upload = move_uploaded_file($file['tmp_name'], realpath('./uploads/videos').'/'.$file['name']);

            if(!$upload) throw new Exception('Error saving vídeo', 406);

            $videoName = $file['name'];
            $videoUrl = 'http://localhost:8000/uploads/videos/'.$videoName;
            
            $post = new Post($user, $body['body'], date('Y-m-d H:i:s'), $videoUrl);
            
            if(!$this->create->save($post)) throw new Exception('Error saving post', 500);
            
            $res->status(201);
            $res->send(['post' => $post]);
        }catch(Exception $e){
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    
    }
}