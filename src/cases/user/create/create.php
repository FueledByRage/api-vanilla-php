<?php
require_once './repositories/IUserRepository.php';
require_once './entities/user.php';

class CreateUser{

    function __construct(
        public iUser $userImplementation
    ){}
    function save(User $user){
        $checkUsername = $this->userImplementation->get($user->username);
        $checkUser = $this->userImplementation->getByEmail($user->email);

        if($checkUsername != null) throw new Exception('Username already registered', 401);
        if($checkUser != null) throw new Exception('User already registered', 401);
        
        return $this->userImplementation->save($user);
    }
}