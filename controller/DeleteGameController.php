<?php
require_once '../Model/AddGame.php';
class DeleteGameController
{
    public function deleteGame(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $gameModel = new AddGame();
            $gameModel->deleteGame($id);

            header('Location: ../View/adminPanel.php');
            exit;
        }
}

}
$deleteGameController = new DeleteGameController();
$deleteGameController->deleteGame();