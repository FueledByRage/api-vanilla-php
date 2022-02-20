<?php
require_once './repositories/IUserRepository.php';
require_once './entities/user.php';

class Login{
    function __construct(
        public IUser $userImplementation
    ){}

    function execute(string $email, string $password){
        $user = $this->userImplementation->getByEmail($email);
        if($user == null) throw new Exception("User not found", 404);
        if($user['password'] == $password){
            return $user;
        }
        throw new Exception('Wrong email or password.', 401);
    }
}