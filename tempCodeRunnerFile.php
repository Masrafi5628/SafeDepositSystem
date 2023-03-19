<?php
if (isset($_POST['login'])) {
    $server = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $con = mysqli_connect($server, $username, $password, $dbname);

    if (!$con) {
        die("connection to this database failed due to" . mysqli_connect_error());
    }

    $email = $_POST['email'];
    $name = $_POST['name'];
    $role = $_POST['role'];

    if ($role == 'employee') {
        $sql = "SELECT * FROM Employee WHERE name='$name' AND email='$email'";
    } else {
        $sql = "SELECT * FROM Customer WHERE name='$name' AND email='$email'";
    }

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) == 1) {
        // login successful, redirect to profile page
        if ($role == 'employee') {
            header('location: employeeProfile.php');
            exit();
        } else {
            header('location: customerProfile.php');
            exit();
        }
    } else {
        // show registration popup
        echo "<script>alert('Please register first.')</script>";
    }

    mysqli_close($con);
}
?>