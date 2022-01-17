<?php
require_once './cases/user/login/controller.php';
require_once './cases/user/login/login.php';
require_once './repositories/implementations/userMysqlImplementation.php';
require_once './providers/database/bd.php';
require_once './utils/checkKeys.php';

$userImplementation = new UserMysql(getConnection());
$login = new Login($userImplementation);
$checkKeys = new CheckKeys();
$loginController = new loginController($login, $checkKeys);