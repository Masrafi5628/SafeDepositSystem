<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('Classes/Database.php');
require_once('Classes/Box.php');

$insert = false;

if (isset($_POST['addBox'])) {

    $db = new Database("localhost", "root", "", "test");
    $con = $db->getConnection();

    $size = $_POST['boxSize'];
    $shelf = $_POST['shelf'];
    $box = new Box($size, $shelf);

    if ($box->saveToDatabase($con)) {
        $insert = true;
    }

    $db->closeConnection();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD BOX</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="registration.css">
</head>

<body>
    <img class="bg" src="bg.jpg">
    <div class="container">
        <h1>Box Information Form</h1>
        <p>Enter the details to add the box to the vault</p>
        <?php
        if ($insert == true) {
            echo "<p class='submitMsg'>Box Added Successfully</p>";
        }
        ?>
        <form action="addBox.php" method="post">
            <!-- <input type="text" name="id" id="id" placeholder="Enter your ID"> -->
            <select name="boxSize" id="boxSize" style="margin:20px;">
                <option value="">Select Box Size</option>
                <option value="3x5">3 x 5</option>
                <option value="5x5">5 x 5</option>
                <option value="3x10">3 x 10</option>
                <option value="5x10">5 x 10</option>
                <option value="10x10">10 x 10</option>
                <option value="15x10">15 x 10</option>
                <option value="13x21">13 x 21</option>
                <option value="26x21">26 x 21</option>
                <option value="38x21">38 x 21</option>
            </select>
            <!-- <input type="double" name="rent" id="rent" placeholder="Enter box rent(dollars/year)"><br> -->
            <input type="number" name="shelf" id="shelf" placeholder="Enter shelf no."><br>

            <button class="btn" name='addBox'>Add Box</button>

        </form>
    </div>
</body>

</html>