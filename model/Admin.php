<?php
include_once '../DBConnection.php';

class Admin
{
    private $conn;
    private $id;
    private $username;
    private $password;

    public function __construct()
    {
        $DBObj = new DBConnection();
        $this->conn = $DBObj->DatabaseConnection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }



    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function findAdmin($email, $password,$rememberme)
    {
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            return false;
        } else {
            $admin = $result->fetch_assoc();
            $this->setId($admin['id']);
            if ($password===$admin['password']) {
                if(isset($rememberme)){

                    setcookie("admin_id",$admin['id'],time()+3600,'/');
                }
                return true;
            } else {
                return false;
            }
        }
    }
}
?>
