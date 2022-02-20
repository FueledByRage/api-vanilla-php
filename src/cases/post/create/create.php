<?php
require_once './repositories/IPostRepository.php';
require_once './entities/post.php';

class CreatePost{

    function __construct(
        public iPost $postImplementation
    ){}
    function save(Post $post){
        
        $saved = $this->postImplementation->save($post);
        
        if(!$saved) throw new Exception('Error saving post.', 500);
    }
}