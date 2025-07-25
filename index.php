<?php
session_start();
header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
require_once 'config/database.php';
require_once 'controllers/UserController.php';
require_once 'controllers/ProductController.php';
require_once 'controllers/CommentController.php';

$controller = $_GET['controller'] ?? 'product';
$action = $_GET['action'] ?? 'index';

switch ($controller) {
    case 'user':
        $controller = new UserController($pdo);
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            die('Action không hợp lệ');
        }
        break;
    case 'product':
        $controller = new ProductController($pdo);
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            die('Action không hợp lệ');
        }
        break;
    case 'comment':
        $controller = new CommentController($pdo);
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            die('Action không hợp lệ');
        }
        break;
    default:
        die('Controller không hợp lệ');
}
