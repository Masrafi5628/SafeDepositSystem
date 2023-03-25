<?php
class Employee
{
    private $name;
    private $email;
    private $phone;
    private $role;
    private $password;
    private $confirm_password;

    public function __construct($name, $email, $phone, $role, $password, $confirm_password)
    {
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->role = $role;
        $this->password = $password;
        $this->confirm_password = $confirm_password;
    }

    public function validatePassword()
    {
        if ($this->password != $this->confirm_password) {
            return false;
        }
        return true;
    }

    public function hashPassword()
    {
        return password_hash($this->password, PASSWORD_DEFAULT);
    }

    public function saveToDatabase($con)
    {
        $name = $this->name;
        $email = $this->email;
        $phone = $this->phone;
        $role = $this->role;
        $password_hash = $this->hashPassword();
        $sql = "INSERT INTO `test`.`Employee` (`name`, `email`, `phone`, `role`, `password_hash`) VALUES ('$name', '$email', '$phone', '$role', '$password_hash');";
        if ($con->query($sql) == true) {
            return true;
        } else {
            echo "ERROR: $sql <br> $con->error";
            return false;
        }
    }
}
?>