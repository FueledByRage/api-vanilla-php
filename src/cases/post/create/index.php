<?php
require_once './cases/post/create/controller.php';
require_once './cases/post/create/create.php';
require_once './repositories/implementations/postMysqlImplementation.php';
require_once './providers/database/bd.php';
require_once './utils/checkKeys.php';
require_once './repositories/implementations/userMysqlImplementation.php';
require_once './providers/jwt/jwt.php';


$jwt = new JWT();
$checkKeys = new CheckKeys();
$postImplementation = new PostMysql(getConnection());
$userImplementation = new UserMysql(getConnection());
$create = new CreatePost($postImplementation, $userImplementation);
$createPostController = new CreatePostController($create, $checkKeys, $jwt);