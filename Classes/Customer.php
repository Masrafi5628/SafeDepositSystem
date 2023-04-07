<?php
class Customer
{
    private $name;
    private $email;
    private $phone;
    private $hair_color;
    private $eye_color;
    public $height;
    private $weight;
    private $gender;
    private $password;
    private $confirm_password;
    private $password_hash;

    public function __construct($name, $email, $phone, $hair_color, $eye_color, $height, $weight, $gender, $password, $confirm_password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->hair_color = $hair_color;
        $this->eye_color = $eye_color;
        $this->height = $height;
        $this->weight = $weight;
        $this->gender = $gender;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
        $this->password_hash = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getConfirmPassword()
    {
        return $this->confirm_password;
    }

    public function validatePasswordsMatch()
    {
        return $this->password == $this->confirm_password;
    }

    public function insertIntoDatabase(Database $database)
    {
        $con = $database->getConnection();
        $sql = "INSERT INTO `test`.`customer` (`name`, `email`, `phone`, `hair_color`, `eye_color`, `height`, `weight`, `gender`, `password_hash`) VALUES ('$this->name', '$this->email', '$this->phone', '$this->hair_color', '$this->eye_color', '$this->height', '$this->weight', '$this->gender', '$this->password_hash');";
        if ($con->query($sql) == true) {
            return true;
        } else {
            echo "ERROR: $sql <br> $con->error";
            return false;
        }
    }
}
?>