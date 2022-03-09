<?php
require_once './repositories/IUserRepository.php';
require_once '././entities/user.php';


class UserMYSQL implements iUser{

    function __construct(
        private PDO $connection
    ){}

    function save(User $user){
        $sql = 'INSERT INTO Users (username, email, password, about) VALUES (:username, :email, :pass, :about);';
        $query = $this->connection->prepare($sql);

        $query->bindValue(":username", $user->username);
        $query->bindValue(":email", $user->email);
        $query->bindValue(":pass", $user->password);
        $query->bindValue(":about", $user->about);

        if($query->rowCount == 0 ) throw new Exception('Error saving post');

        return $query->execute();
    }
    function get(string $username){
        $connection = getConnection();
        $sql = 'SELECT * FROM Users WHERE username = :username';
        $data = $connection->prepare($sql);
        $data->bindValue(":username", $username);
        $data->execute();
        if($data->rowCount() == 0) throw new Exception('Error getting user');
        return $data->fetch();
    }
    function getByEmail(string $email){
        $connection = getConnection();
        $sql = 'SELECT * FROM Users WHERE email = :email';
        $data = $connection->prepare($sql);
        $data->bindValue(":email", $email);
        $data->execute();
        if($data->rowCount() == 0) throw new Exception('Error getting user');
        return $data->fetch();
    }
}