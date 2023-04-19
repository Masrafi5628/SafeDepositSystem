<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('Classes/Database.php');
require_once('Classes/Employee.php');

$insert = false;

if (isset($_POST['register'])) {
    
    $db = new Database("localhost", "root", "", "test");
    $con = $db->getConnection();

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $employee = new Employee($name, $email, $phone, $role, $password, $confirm_password);

    if (!$employee->validatePassword()) {
        echo "<p class='error'>Error: Passwords do not match.</p>";
    } else {
        if ($employee->saveToDatabase($con)) {
            $insert = true;
        }
    }

    $db->closeConnection();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="registration.css">
</head>

<body>
    <img class="bg" src="bg.jpg">
    <div class="container">
        <h1>Employee Registration Form</h1>
        <p>Enter your details to Register as an Employee</p>
        <?php
        if ($insert == true) {
            echo "<p class='submitMsg'>Thanks for Registering</p>";
        }
        ?>
        <form action="employee_registration.php" method="post">
            <!-- <input type="text" name="id" id="id" placeholder="Enter your ID"> -->
            <input type="text" name="name" id="name" placeholder="Enter your name">
            <input type="email" name="email" id="email" placeholder="Enter your email"><br>
            <input type="text" name="phone" id="phone" placeholder="Enter your phone"><br>
            <label for="role">Role:</label><br>
            <select id="role" name="role" style="margin:10px;">
                <option value="Biller">Biller</option>
                <option value="VaultManager">VaultManager</option>
                <option value="Analyst">Analyst</option>
            </select><br>
            <input type="password" name="password" id="password" placeholder="Enter your password"><br>
            <input type="password" name="confirm_password" id="confirm_password"
                placeholder="Confirm your password"><br>
            <button class="btn" name='register'>Submit</button>
            <a href="login.php" class="btn" style="position: absolute; top: 20px; right: 20px;">Login</a>

        </form>
    </div>
</body>

</html>