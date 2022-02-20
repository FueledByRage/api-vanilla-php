<?php

class Response{

    public $status;

    public function status($status){
        $this->status = $status;
    }
    public function send($content){
        http_response_code($this->status ? $this->status : 200);
        echo json_encode($content);
        die();
    }
}