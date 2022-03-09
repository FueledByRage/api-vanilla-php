<?php
require_once './repositories/IPostRepository.php';
require_once './repositories/IUserRepository.php';
require_once './entities/post.php';

class CreatePost{

    function __construct(
        public iPost $postImplementation,
        public IUser $userImplementation 
    ){}
    
    function save(Post $post){
        
        $user = $this->userImplementation->get($post->author);

        if(!$user) throw new Exception('User not found', 404);

        $saved = $this->postImplementation->save($post, $user['id']);
        
        if(!$saved) throw new Exception('Error saving post.', 500);
        return $saved;
    }
}