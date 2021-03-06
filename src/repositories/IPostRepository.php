<?php


require_once './entities/post.php';


interface IPost{
    function save(Post $post, $author_id);
    function getAll($author);
    function get($author, $id);
    function delete($id, $username);
}