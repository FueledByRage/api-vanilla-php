<?php
require('controller.php');
require_once './cases/user/create/create.php';
require_once './repositories/implementations/userMysqlImplementation.php';
require_once './providers/database/bd.php';
require_once './utils/checkKeys.php';


$checkKeys = new CheckKeys();
$userImplementation = new UserMysql(getConnection());
$create = new CreateUser($userImplementation);
$createController = new Controller($create, $checkKeys);