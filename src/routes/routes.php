<?php
require_once './providers/database/bd.php';
require_once './providers/jwt/jwt.php';
require_once './cases/user/create/index.php';
require_once './cases/user/login/index.php';
require_once './cases/user/get/index.php';
require_once './cases/post/create/index.php';
require_once './cases/post/get/index.php';
require_once './routes/urlHandler.php';
require_once './routes/router.php';


$router = new Router(new URLHandler);

$router->GET('/user/?username', $getController);

$router->GET('/post/?author', $getPostsController);

$router->POST('/user/register', $createUserController);

$router->POST('/post/register', $createPostController);

$router->POST('/login', $loginController);