<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');

require_once '../Model/AddGame.php';

class AddGameController
{
    public function AddGameDataToDatabase()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "Form is submitted.<br>";

            $title = $_POST['title'];
            $genre = $_POST['genre'];
            $platform = $_POST['platform'];

            $price = $_POST['price'];

            $image = $_FILES['image'];


            if ( $image['error'] === UPLOAD_ERR_OK) {
                echo "Files uploaded successfully.<br>";



                // For image
                $fileTmpPath1 = $image['tmp_name'];
                $fileName1 = $image['name'];
                $fileExtension1 = strtolower(pathinfo($fileName1, PATHINFO_EXTENSION));
                $newFileName1 = $title . '_image.' . $fileExtension1;
                $uploadFileDir1 = 'C:/xampp1/htdocs/my_projects/AdminOperations/images/';
                $dest_path1 = $uploadFileDir1 . $newFileName1;

                if (move_uploaded_file($fileTmpPath1, $dest_path1)) {
                    echo "Files moved successfully.<br>";

                    $addGameObj = new AddGame();
                    $addResult = $addGameObj->InsertGameDetails($title, $genre, $platform,  $price, $newFileName1);

                    if (!$addResult) {
                        echo "Data Insertion Failed";
                    } else {
                        echo "Data added successfully";
                        header('Location: ../View/viewGameDetails.php');
                        echo json_encode(['message' => 'Data processed successfully']);

                        exit;
                    }
                } else {
                    echo "Error moving files.";
                }
            } else {
                echo "Error uploading files.";
            }
        } else {
            echo "Form not submitted.";
        }


    }
}

$addGameController = new AddGameController();
$addGameController->AddGameDataToDatabase();
?>
