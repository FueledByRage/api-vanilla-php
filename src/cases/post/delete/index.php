<?php
require_once './cases/post/delete/controller.php';
require_once './cases/post/delete/delete.php';
require_once './repositories/implementations/postMysqlImplementation.php';
require_once './providers/database/bd.php';
require_once './utils/checkKeys.php';
require_once './providers/jwt/jwt.php';


$jwt = new JWT();
$checkKeys = new CheckKeys();
$postImplementation = new PostMysql(getConnection());
$delete = new DeletePost($postImplementation);
$deletePostController = new DeleteController($delete, $jwt, $checkKeys);