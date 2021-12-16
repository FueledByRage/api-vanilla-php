<?php
require_once './repositories/IPostRepository.php';
require_once '././entities/post.php';


class PostMysql implements IPost{

    function __construct(
        private PDO $connection,
    ){}

    function save(Post $post){
        try{
            $sql = 'INSERT INTO Posts (author, body, date) VALUES (:author, :body, :date);';
            $query = $this->connection->prepare($sql);
            $query->bindValue(":author", $post->author);
            $query->bindValue(":body", $post->body);
            $query->bindValue(":date", $post->date);
            $query->execute(); 
        }catch(Exception $e){
            http_response_code(500);
            echo $e->getMessage();
        }
    }
    function getAll($author){
        try{
            $sql = 'SELECT * FROM Posts WHERE author = :author';
            $data = $this->connection->prepare($sql);
            $data->bindValue(":author", $author);
            $data->execute();
            if($data->rowCount() == 0){
                throw new Exception("Posts not found for this user.", 404);
            }
            return $data->fetchAll();
        }catch(Exception $e){
            echo $e->getMessage();
        }
    }
}