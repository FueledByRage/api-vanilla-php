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
            
            if(!$this->checkKeys->execute($body, ['body', 'token'])) throw new Exception('Missing credentials', 406);    
            
            $user = $jwt->decript($body['token'])->{'username'};
            
            $file = $req->getFile('file');

            if(!$file) throw new Exception('Vídeo not found.', 406);

            $upload = move_uploaded_file($file['tmp_name'], realpath('./uploads/videos').'/'.$file['name']);

            if(!$upload) throw new Exception('Error saving vídeo', 406);

            $videoName = $file['name'];
            $videoUrl = 'http://localhost:8000/uploads/videos/'.$videoName;
            
            $post = new Post($user, $body['body'], date('Y-m-d H:i:s'), $videoUrl);
            
            $this->create->save($post);
            
            $res->status(201);
            $res->send(['post' => $post]);
            die();
        }catch(Exception $e){
            $res->status($e->getCode());
            $res->send(['message' => $e->getMessage()]);
        }
    
    }
}