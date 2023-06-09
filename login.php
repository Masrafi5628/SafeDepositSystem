<?php
require_once('Classes/Database.php');
require_once('header.php');

if (isset($_POST['login'])) {
    $db = new Database("localhost", "root", "", "test");

    $con = $db->getConnection();
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = $_POST['password'];

    if ($role == 'employee') {
        $sql = "SELECT id,role,password_hash FROM employee WHERE email='$email'";
    } else {
        $sql = "SELECT id,password_hash FROM customer WHERE email='$email'";
    }

    $result = mysqli_query($con, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $hashed_password = $row['password_hash'];
        if (password_verify($password, $hashed_password)) {
            Session::init();
            Session::set('id', $row['id']);
            $_SESSION['ID'] = $row['id'];
            if ($role == 'employee') {
                $roleN = $row['role'];
                // echo $roleN;

                if (strtolower($roleN) == 'biller') {
                    header('location: billerProfile.php');
                    exit();
                } else if (strtolower($roleN) == 'vaultmanager') {
                    header('location: vaultManagerProfile.php');
                    exit();
                } else if (strtolower($roleN) == 'analyst') {
                    header('location: analystProfile.php');
                    exit();
                }
            } else {
                header('location: customerProfile.php');
                exit();
            }
        } else {
            echo "<script>alert('Invalid password.')</script>";
        }
    } else {
        echo "<script>alert('Please register first.')</script>";
    }
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="registration.css">
</head>

<body>
    <img class="bg" src="bg.jpg">
    <div class="container">
        <h1>Login Form</h3>
            <p>Enter your details to Login </p>
            <form action="login.php" method="post">
                <!-- <input type="text" name="name" id="name" placeholder="Enter your name"> -->
                <input type="email" name="email" id="email" placeholder="Enter your email">
                <input type="password" name="password" id="password" placeholder="Enter your password">

                <label for="role">Role:</label><br>
                <select id="role" name="role" style="margin:10px;">
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                </select>
                <button class="btn" name="login">Login</button>
            </form>
    </div>
    <script src="index.js">  </script>
</body>

</html>