<?php

class Request{
    public function __construct(){
        $this->setAtributes();
    }

    function setAtributes(){
        $params = [];
        foreach($_SERVER as $key => $value){
            $this->$key = $value;
        }
        
        if($_SERVER['REQUEST_METHOD'] == 'GET')parse_str($this->getParams('http://localhost:8000/'.$_SERVER['REQUEST_URI']), $params);

        $this->params = $params;
    }

    function getParams($url){
        return parse_url($url, PHP_URL_QUERY);
    }

    function body(){
        
        $body = [];


        if($this->REQUEST_METHOD == 'POST'){
            
            //If the request come from a js interface it has been sent as a stringify json,
            //so the $_POST size gotta be equals 1
            if(count($_POST) == 1) return json_decode(file_get_contents('php://input'), true);
                
            foreach($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
            return $body;
        }
    }
    function getFile(string $fileName){
        $file = $_FILES[$fileName];

        if($file) return $file;
        return null;
    }
}