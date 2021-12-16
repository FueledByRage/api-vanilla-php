<?php
    require_once './entities/user.php';

interface iUser{

    public function save(User $user);
    public function get(string $email);

}