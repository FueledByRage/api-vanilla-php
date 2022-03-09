<?php
require('controller.php');
require_once './cases/user/create/create.php';
require_once './providers/database/bd.php';
require_once './repositories/implementations/userMysqlImplementation.php';
require_once './utils/checkKeys.php';
require_once './providers/jwt/jwt.php';


$jwt = new JWT();
$checkKeys = new CheckKeys();
$userImplementation = new UserMysql(getConnection());
$create = new CreateUser($userImplementation);
$createUserController = new Controller($create, $checkKeys, $jwt);