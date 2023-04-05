<?php
require_once('header.php');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="registration.css">
</head>

<body>
    <img class="bg" src="bg.jpg">
    <div class="container">
        <h1>Please Choose your intended operation</h3>
            <a class="btn" name="rentBox" href="rentBox.php" style="display: block;text-align: center;margin:20px;">Rent Box</a><br>
            <a class="btn" name="checkStatus" href="makePayment.php" style="display: block;text-align: center;margin:20px;">Make Payment</a>
            <?php
            echo $_SESSION['ID'];
            ?>
    </div>
    <script src="index.js">  </script>
</body>

</html>