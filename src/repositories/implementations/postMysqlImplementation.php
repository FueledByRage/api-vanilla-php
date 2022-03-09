<?php
require_once './repositories/IPostRepository.php';
require_once '././entities/post.php';


class PostMysql implements IPost{

    function __construct(
        private PDO $connection,
    ){}

    function save(Post $post, $author_id){
        try{
            $sql = 'INSERT INTO Posts (author_id, author,  body, created_at, videoUrl) VALUES (:author_id, :author, :body, :date, :videoUrl);';
            
            $query = $this->connection->prepare($sql);
            $query->bindValue(":author_id", $author_id);
            $query->bindValue(":author", $post->author);
            $query->bindValue(":body", $post->body);
            $query->bindValue(":date", $post->created_date);
            $query->bindValue(":videoUrl", $post->videoUrl);

            return $query->execute();
        }catch(Exception $e){
            http_response_code(500);
            echo $e->get_message();
            die();
        }
    }

    function get($author, $id){
        $sql = 'SELECT * FROM POSTS WHERE author = :author AND _id == :id';
        $data = $this->connection->prepare($sql);
        $data->bindValue(":author", $author);
        $data->bindValue(":id", $id);
        $data->execute();
        if($data->rowCount() == 0){
            throw new Exception("Posts not found for this user.", 404);
        }
        return $data->fetchAll();
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
            http_response_code(500);
            echo $e->getMessage();
            die();
        }
    }

    function delete($id, $username){
        $sql = 'DELETE FROM Posts Where id = :id AND author = :author';
         
        $executeDelete = $this->connection->prepare($sql);
        $executeDelete->bindValue(":id", $id);
        $executeDelete->bindValue(":author", $username);
        $stmn = $executeDelete->execute(); 
        if($executeDelete->rowCount() > 0){
            return true;
        }

        throw new Exception('Error deleting post', 500);
    }
}