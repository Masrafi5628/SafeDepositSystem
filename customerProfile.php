<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
require_once 'Classes/Database.php';
require_once 'Classes/Customer.php';
require_once 'Classes/Session.php';
Session::init();

$db = new Database("localhost", "root", "", "test");
$result = $db->query("SELECT * FROM customer where id=" . $_SESSION['ID']);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./registration.css">
</head>
<body>
<?php if ($result->num_rows > 0) { ?>
    <div class="gallery">
        <?php while ($row = $result->fetch_assoc()) {
            if ($row['photo'] != null) ?>
            <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['photo']); ?>" height="150px" width="150px" style="display: block;margin-left: auto;margin-right: auto;"/>
        <?php } ?>
    </div>
<?php } else { ?>
    <p class="status error">Image(s) not found...</p>
<?php } ?>


    <img class="bg" src="bg.jpg">
    <div class="container">
        <h1>Please Choose your intended operation</h3>
            <a class="btn" name="rentBox" href="rentBox.php" style="display: block;text-align: center;margin:20px;">Rent
                Box</a><br>
            <a class="btn" name="checkStatus" href="makePayment.php"
                style="display: block;text-align: center;margin:20px;">Make Payment</a>
            <?php
            echo $_SESSION['ID'];
            ?>
    </div>
    <script src="index.js">  </script>
</body>

</html>