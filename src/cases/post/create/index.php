<?php
require_once './cases/post/create/controller.php';
require_once './cases/post/create/create.php';
require_once './repositories/implementations/postMysqlImplementation.php';
require_once './providers/database/bd.php';
require_once './utils/checkKeys.php';


$checkKeys = new CheckKeys();
$postImplementation = new PostMysql(getConnection());
$create = new CreatePost($postImplementation);
$createPostController = new CreatePostController($create, $checkKeys);