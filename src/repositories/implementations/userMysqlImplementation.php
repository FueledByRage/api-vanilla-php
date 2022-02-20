<?php
require_once './repositories/IUserRepository.php';
require_once '././entities/user.php';


class UserMYSQL implements iUser{

    function __construct(
        private PDO $connection
    ){}

    function save(User $user){
        try{
            $sql = 'INSERT INTO Users (username, email, password, about) VALUES (:username, :email, :pass, :about);';
            $query = $this->connection->prepare($sql);

            $query->bindValue(":username", $user->username);
            $query->bindValue(":email", $user->email);
            $query->bindValue(":pass", $user->password);
            $query->bindValue(":about", $user->about);

            return $query->execute();
        }catch(\Throwable $th){
            http_response_code(500);
            echo json_encode(['error' => $th->getMessage()]);
            die();
        }
    }
    function get(string $username){
        $connection = getConnection();
        $sql = 'SELECT * FROM Users WHERE username = :username';
        $data = $connection->prepare($sql);
        $data->bindValue(":username", $username);
        $data->execute();
        if($data->rowCount() == 0){
            return null;
        }
        return $data->fetch();
    }
    function getByEmail(string $email){
        try {
            $connection = getConnection();
            $sql = 'SELECT * FROM Users WHERE email = :email';
            $data = $connection->prepare($sql);
            $data->bindValue(":email", $email);
            $data->execute();
            if($data->rowCount() == 0){
                return null;   
            }
            return $data->fetch();
        } catch (\Throwable $th) {
            //throw $th;
            http_response_code(500);
            echo $th;
            //echo json_decode(json_encode(['error' => $th]));
            die();
        }
    }
}