<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'Classes/Database.php';
require_once 'Classes/Customer.php';

$insert = false;
if (isset($_POST['register'])) {
    $database = new Database("localhost", "root", "", "test");
    $customer = new Customer($_POST['name'], $_POST['email'], $_POST['phone'], $_POST['hair_color'], $_POST['eye_color'], $_POST['height'], $_POST['weight'], $_POST['gender'], $_POST['password'], $_POST['confirm_password']);
    if (!$customer->validatePasswordsMatch()) {
        echo "<p class='error'>Error: Passwords do not match.</p>";
    } else {
        if ($customer->insertIntoDatabase($database)) {

            // Add the picture to the database
            if (!empty($_FILES["picture"]["name"])) {
                $picture = $_FILES['picture']['tmp_name'];
                $imgContent = addslashes(file_get_contents($picture));
                $insertPicture = $database->query("UPDATE customer SET photo = '$imgContent' WHERE email = '" . $_POST['email'] . "'");
            }

            // Add the signature to the database
            if (!empty($_FILES["signature"]["name"])) {
                $signature = $_FILES['signature']['tmp_name'];
                $imgContent = addslashes(file_get_contents($signature));
                $insertSignature = $database->query("UPDATE customer SET sign = '$imgContent' WHERE email = '" . $_POST['email'] . "'");
            }

            // Add the NID to the database
            if (!empty($_FILES["nid"]["name"])) {
                $nid = $_FILES['nid']['tmp_name'];
                $imgContent = addslashes(file_get_contents($nid));
                $insertNID = $database->query("UPDATE customer SET nid = '$imgContent' WHERE email = '" . $_POST['email'] . "'");
            }
            echo "Done" . "<br>";

            $insert = true;
        } else {
            echo "<p class='error'>Error: Failed to insert record into database.</p>";
        }
    }

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
        <h1>Registration Form</h1>
        <p>Enter your details to Register as a Customer</p>
        <?php
        if ($insert == true) {
            echo "<p class='submitMsg'>Thanks for Registering</p>";
        }
        ?>
        <form action="customer_registration.php" method="post" enctype="multipart/form-data">
            <input type="text" name="name" id="name" placeholder="Enter your name">
            <input type="email" name="email" id="email" placeholder="Enter your email"><br>
            <input type="text" name="phone" id="phone" placeholder="Enter your phone"><br>
            <input type="text" name="hair_color" id="hair_color" placeholder="Enter your hair color"><br>
            <input type="text" name="eye_color" id="eye_color" placeholder="Enter your eye color"><br>
            <input type="double" name="height" id="height" placeholder="Enter your height (in cm)"><br>
            <input type="double" name="weight" id="weight" placeholder="Enter your weight (in lbs)"><br>
            <div style="display:flex;">
                <label for="gender">Gender:</label><br>
                <input type="radio" id="male" name="gender" value="male">
                <label for="male">Male</label>
                <input type="radio" id="female" name="gender" value="female">
                <label for="female">Female</label><br>
            </div>
            <input type="password" name="password" id="password" placeholder="Enter your password"><br>
            <input type="password" name="confirm_password" id="confirm_password"
                placeholder="Confirm your password"><br>
            Upload your photo
            <input type="file" name="picture" id="picture" accept="image/*">
            Upload signature
            <input type="file" name="signature" id="signature" accept="image/*">
            Upload scanned NID
            <input type="file" name="nid" id="nid" accept="image/*">
            <button class="btn" name='register'>Submit</button>
            <a href="login.php" class="btn" style="position: absolute; top: 20px; right: 20px;">Login</a>

        </form>

    </div>
</body>

</html>