<?php
session_start();
include_once '../Model/Admin.php';
include_once '../Model/User.php';
header('Content-Type: application/json');

class LoginController
{
    public function LoginConfirmation()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
            $rememberme= filter_input(INPUT_POST, 'rememberme', FILTER_SANITIZE_STRING);

            $UserObj = new User();
            $results = $UserObj->FindUser($email, $password,$rememberme);

            $adminObj = new Admin();
            $adminResults = $adminObj->findAdmin($email, $password,$rememberme);
            if ($results) {
                $_SESSION['user_id']=$UserObj->getId();
                $redirectUrl = '/Applications/XAMPP/xamppfiles/htdocs/AdminOperations/View/viewGameDetails.php';
                echo json_encode(['status' => 'success', 'message' => 'Login Successful', 'redirect' => $redirectUrl]);
                exit;
            } elseif ($adminResults) {
                $_SESSION['admin_id']=$adminObj->getId();
                $redirectUrl = '/Applications/XAMPP/xamppfiles/htdocs/AdminOperations/View/adminPanel.php';
                echo json_encode(['status' => 'success', 'message' => 'Login Successful', 'redirect' => $redirectUrl]);
                exit;
            } else {
                $redirectUrl = '/Applications/XAMPP/xamppfiles/htdocs/AdminOperations/View/login.php';
                echo json_encode(['status' => 'error', 'message' => 'Login Unsuccessful', 'redirect' => $redirectUrl]);
                exit;
            }
        } else {
            $redirectUrl = '/Applications/XAMPP/xamppfiles/htdocs/AdminOperations/View/login.php';
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method', 'redirect' => $redirectUrl]);
            exit;
        }

    }
}

$loginController = new LoginController();
$loginController->LoginConfirmation();
?>
