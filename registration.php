<?php
$insert = false;
if (isset($_POST['register'])) {
    $server = "localhost";
    $username = "root";
    $password = "";

    $con = mysqli_connect($server, $username, $password);

    if (!$con) {
        die("connection to this database failed due to" . mysqli_connect_error());
    }
    // echo "Success connecting to the db";

    // Collect post variables
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];
    if($role=="customer"){
        $sql = "INSERT INTO `test`.`Customer` (`name`, `email`, `phone`) VALUES ('$name', '$email', '$phone');";
    }
    else{
        $sql = "INSERT INTO `test`.`Employee` (`name`, `email`, `phone`) VALUES ( '$name', '$email', '$phone');";

    }
    // echo $sql;

    // Execute the query
    if ($con->query($sql) == true) {
        // echo "Successfully inserted";

        // Flag for successful insertion
        $insert = true;
    } else {
        echo "ERROR: $sql <br> $con->error";
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
        <h1>Registration Form</h3>
            <p>Enter your details to Register </p>
            <?php
            if ($insert == true) {
                echo "<p class='submitMsg'>Thanks for Registering</p>";
            }
            ?>
            <form action="registration.php" method="post">
                <input type="text" name="name" id="name" placeholder="Enter your name">
                <input type="email" name="email" id="email" placeholder="Enter your email">
                <input type="phone" name="phone" id="phone" placeholder="Enter your phone"><br>
                <label for="role">Role:</label><br>
                <select id="role" name="role" style = "margin:10px;">
                    <option value="customer">Customer</option>
                    <option value="employee">Employee</option>
                </select>
                <button class="btn" name='register'>Submit</button>
            </form>
    </div>
</body>

</html>