<?php
require_once './repositories/IPostRepository.php';
require_once './entities/post.php';

class CreatePost{

    function __construct(
        public iPost $postImplementation
    ){}
    function save(Post $post){
        $this->postImplementation->save($post);
    }
}