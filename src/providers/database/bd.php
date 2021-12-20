<?php


function getConnection(){
    try{
        return new PDO('mysql:host=localhost;dbname=PHPTEST', 'root', 'gomugomu42');
    }catch(Exception $e){
        http_response_code(500);
        echo json_encode(['message' => 'Error connecting to DB']);
        die();
    }
}