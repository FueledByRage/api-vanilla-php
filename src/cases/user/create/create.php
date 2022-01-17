<?php
require_once './repositories/IUserRepository.php';
require_once './entities/user.php';

class CreateUser{

    function __construct(
        public iUser $userImplementation
    ){}
    function save(User $user){
        $checkUser = $this->userImplementation->getByEmail($user->email);
        if($checkUser != null) throw new Exception('User already registered', 401);
        return $this->$userImplementation->save($user);
    }
}