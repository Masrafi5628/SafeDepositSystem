<?php
$insert = false;
if (isset($_POST['register'])) {
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "test";

    $con = mysqli_connect($server, $username, $password, $database);
    if (!$con) {
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    // echo "Success connecting to the db";
    // Collect post variables
    // $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if ($password != $confirm_password) {
        echo "<p class='error'>Error: Passwords do not match.</p>";
    } else {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO `test`.`Employee` ( `name`, `email`, `phone`, `role`, `password_hash`) VALUES ( '$name', '$email', '$phone', '$role', '$password_hash');";

        // Execute the query
        if ($con->query($sql) == true) {
            $insert = true;
        } else {
            echo "ERROR: $sql <br> $con->error";
        }
    }

    // Close the database connection
    $con->close();
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
            </select><br>
            <input type="password" name="password" id="password" placeholder="Enter your password"><br>
            <input type="password" name="confirm_password" id="confirm_password"
                placeholder="Confirm your password"><br>
            <button class="btn" name='register'>Submit</button>
        </form>
    </div>
</body>

</html>
