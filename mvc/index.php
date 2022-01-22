<?php 
require_once "controller\MobileController.php";

//khởi tạo controller object
$controller = new MobileController;
//thực hiện phương thức mvcHandler trong controlller
$controller->mvcHandler();
?>