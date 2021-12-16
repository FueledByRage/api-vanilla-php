<?php


require_once './entities/post.php';


interface IPost{
    function save(Post $post);
    function getAll($author);
}