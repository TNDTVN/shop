<?php
require_once 'config/database.php';
require_once 'models/User.php';

class UserController
{
    private $user;

    public function __construct($pdo)
    {
        $this->user = new User($pdo);
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $user = $this->user->login($email, $password);
            if ($user) {
                $_SESSION['user_id'] = $user['id'];
                header('Location: /shop/?controller=product&action=index');
                exit;
            } else {
                $_SESSION['error'] = "Email hoặc mật khẩu không đúng";
                header('Location: /shop/?controller=user&action=login');
                exit;
            }
        }
        require 'views/auth/login.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if ($this->user->register($name, $email, $password)) {
                header('Location: /shop/?controller=user&action=login');
                exit;
            } else {
                $_SESSION['error'] = "Đăng ký thất bại";
                header('Location: /shop/?controller=user&action=register');
                exit;
            }
        }
        require 'views/auth/register.php';
    }

    public function logout()
    {
        session_destroy();
        header('Location: /shop/?controller=user&action=login');
        exit;
    }
}
