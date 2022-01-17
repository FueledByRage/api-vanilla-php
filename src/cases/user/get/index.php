<?php
require_once './cases/user/get/controller.php';
require_once './cases/user/get/get.php';
require_once './repositories/implementations/userMysqlImplementation.php';
require_once './providers/database/bd.php';



$userImplementation = new UserMysql(getConnection());
$get = new GetUser($userImplementation);
$getController = new GetController($get);