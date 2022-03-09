<?php
require_once './cases/post/get/controller.php';
require_once './cases/post/get/get.php';
require_once './repositories/implementations/postMysqlImplementation.php';
require_once './providers/database/bd.php';


$postImplementation = new PostMysql(getConnection());
$get = new GetPosts($postImplementation);
$getPostsController = new GetPostsController($get);