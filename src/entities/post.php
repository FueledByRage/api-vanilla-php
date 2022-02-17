<?php

class Post{

    function __construct(
        public $author,
        public $body,
        public $created_date,
        public $videoUrl
    ){}

}