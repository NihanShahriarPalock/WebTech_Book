<?php

require_once '../webtech_project/controller/controller.php';


$action = isset($_GET['action']) ? $_GET['action'] : 'login';

handleAction($action);

?>