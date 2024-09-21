<?php
include_once '../Model/User.php';
header('Content-Type: application/json');

class AddUserController
{
    public function AddUserDataToDatabase()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $fname = filter_input(INPUT_POST, 'fname', FILTER_SANITIZE_STRING);
            $lname = filter_input(INPUT_POST, 'lname', FILTER_SANITIZE_STRING);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);

            $errors = [];
            $response = null;
            if (empty($fname)) {
                $errors[] = "First name is required.";
            }

            if (empty($lname)) {
                $errors[] = "Last name is required.";
            }

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "A valid email address is required.";
            }

            if (empty($password)) {
                $errors[] = "Password is required.";
            }

            if (empty($errors)) {
                $addUserObj = new User();

                if ($addUserObj->CheckEmailExists($email)) {
                    $errors[] = "User already exists.";
                } else {
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $addResult = $addUserObj->InsertUserDetails($fname, $lname, $email, $hashedPassword);

                    if (!$addResult) {
                        $errors[] = "Data insertion failed.";
                    } else {
                        $response = ['success' => "Data added successfully."];
                    }
                }
            }

            if (!empty($errors)) {
                $response = ['errors' => $errors];
            }

            echo json_encode($response);
            exit;
        }
    }
}

$addUserController = new AddUserController();
$addUserController->AddUserDataToDatabase();
?>