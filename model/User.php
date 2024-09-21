<?php
include_once '../DBConnection.php';
class User
{
    private $conn;
    private $id;
    private $username;
    private $password;
    private $fname;
    private $lname;


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

    /**
     * @return mixed
     */


    public function InsertUserDetails($fname, $lname, $email,  $password)
    {


        $sql = "INSERT INTO user (firstName, lastName, email, password)
                VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $stmt->bind_param("ssss", $fname, $lname, $email,  $password);
        $result = $stmt->execute();

        if ($result === false) {
            die('Execute failed: ' . $stmt->error);
        }

        $stmt->close();
        return $result;
    }

    public function CheckEmailExists($email)
    {
        $sql = "SELECT email FROM user WHERE email = ?";
        $stmt = $this->conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $this->conn->error);
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        $exists = $stmt->num_rows > 0;

        $stmt->close();
        return $exists;
    }

    public function FindUser($email,$password,$rememberme){

        $sql="SELECT * FROM user WHERE email=?";
        $stmt=$this->conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $this->conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            return false;
        } else {
            $user = $result->fetch_assoc();
            $this->setId($user['id']);
            if (password_verify($password, $user['password'])) {

                if(isset($rememberme)){

                    setcookie("user_id",$user['id'],time()+3600,'/');
                }
                return true;

            } else {

                return false;
            }
        }

    }
}