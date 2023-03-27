<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('Classes/Database.php');
require_once('Classes/Box.php');

$insert = false;

if (isset($_POST['updateRent'])) {

    $db = new Database("localhost", "root", "", "test");
    $con = $db->getConnection();

    $date = date('Y-m-d');

    $sql = "SELECT MAX(date) FROM rent";
    $result = $con->query($sql);
    $row = $result->fetch_assoc();
    $max_date = $row['MAX(date)'];

    if ($date == $max_date) {
        echo "<script>alert('You can not update rent more than once in a day.')</script>";
    } else {
        $rent1 = $_POST['rent1'];
        $rent2 = $_POST['rent2'];
        $rent3 = $_POST['rent3'];
        $rent4 = $_POST['rent4'];
        $rent5 = $_POST['rent5'];
        $rent6 = $_POST['rent6'];
        $rent7 = $_POST['rent7'];
        $rent8 = $_POST['rent8'];
        $rent9 = $_POST['rent9'];

        $sql = "INSERT INTO rent (date, box_size, rent)
            VALUES ('$date', '3x5', '$rent1'),
                   ('$date', '5x5', '$rent2'),
                   ('$date', '3x10', '$rent3'),
                   ('$date', '5x10', '$rent4'),
                   ('$date', '10x10', '$rent5'),
                   ('$date', '15x10', '$rent6'),
                   ('$date', '13x21', '$rent7'),
                   ('$date', '26x21', '$rent8'),
                   ('$date', '38x21', '$rent9')";

        if ($con->query($sql) === TRUE) {
            echo "<script>alert('Rent data saved successfully.')</script>";
            $insert = true;
        } else {
            echo "Error: " . $sql . "<br>" . $con->error;
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
    <title>Update Rent</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="registration.css">
</head>

<body>
    <img class="bg" src="bg.jpg">
    <div class="container">
        <h1>Rent Updating Form</h1>
        <p>Enter the rent of each box size</p>
        <?php
        if ($insert == true) {
            echo "<p class='submitMsg'>Rents Updated Successfully</p>";
        }
        ?>
        <form method="post" action="updateRent.php">
            <label for="rent_3x5">Rent for 3x5:</label>
            <input type="number" name="rent1" id="rent_3x5"><br>

            <label for="rent_5x5">Rent for 5x5:</label>
            <input type="number" name="rent2" id="rent_5x5"><br>

            <label for="rent_3x10">Rent for 3x10:</label>
            <input type="number" name="rent3" id="rent_3x10"><br>

            <label for="rent_5x10">Rent for 5x10:</label>
            <input type="number" name="rent4" id="rent_5x10"><br>

            <label for="rent_10x10">Rent for 10x10:</label>
            <input type="number" name="rent5" id="rent_10x10"><br>

            <label for="rent_15x10">Rent for 15x10:</label>
            <input type="number" name="rent6" id="rent_15x10"><br>

            <label for="rent_13x21">Rent for 13x21:</label>
            <input type="number" name="rent7" id="rent_13x21"><br>

            <label for="rent_26x21">Rent for 26x21:</label>
            <input type="number" name="rent8" id="rent_26x21"><br>

            <label for="rent_38x21">Rent for 38x21:</label>
            <input type="number" name="rent9" id="rent_38x21"><br>

            <button class="btn" name='updateRent'>Update Rent</button>
            <!-- <input type="submit" value="Submit"> -->
        </form>

    </div>
</body>

</html>