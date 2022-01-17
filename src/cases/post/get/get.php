<?php
require_once './repositories/IUserRepository.php';
require_once './entities/user.php';

class GetPosts{

    function __construct(
        public iPost $postImplementation
    ){}
    function get(String $author){
        $data = $this->postImplementation->getAll($author);
        return $data;
    }
}