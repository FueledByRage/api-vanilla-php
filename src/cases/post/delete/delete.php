<?php
require_once './repositories/IPostRepository.php';
require_once './repositories/IUserRepository.php';
require_once './entities/post.php';

class DeletePost{

    function __construct(
        public iPost $postImplementation,
    ){}

    function execute(string $id, string $username){

        return $this->postImplementation->delete($id, $username);
    }
}