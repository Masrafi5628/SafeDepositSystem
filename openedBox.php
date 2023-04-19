<?php
// handle checkout
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('Classes/Database.php');
require_once('Classes/Session.php');
require_once('Classes/Customer.php');
Session::init();

$db = new Database("localhost", "root", "", "test");
$conn = $db->getConnection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$box_id = $_SESSION['box_id'];
$customer_id = $_SESSION['ID'];
$current_time = date('Y-m-d H:i:s');

if (isset($_POST['checkout'])) {
    $update_query = "UPDATE box_activity_log SET check_out_time = '$current_time' WHERE box_id = '$box_id' AND customer_id = '$customer_id' AND check_out_time IS NULL";
    if ($conn->query($update_query) === false) {
        echo "Error: " . $update_query . "<br>" . $conn->error;
    } else {
        header("Location: openBox.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Box Opened</title>
    <style>
        body {
            background-color: #f1f1f1;
        }

        .container {
            margin: 50px auto;
            width: 50%;
            text-align: center;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
        }

        img {
            margin-top: 30px;
            max-width: 100%;
            height: auto;
        }

        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Congratulations!</h1>
        <p>You have successfully opened the box.</p>
        <p>Don't forget to checkout when you are done. Thank you.</p>
        <img src="boxOpened.jpeg" alt="Box opened image"><br>
        <form method="post" action="openedBox.php">
            <input type="hidden" name="box_id" value="<?php echo $_GET['id']; ?>">
            <input type="hidden" name="checkout" value="true">
            <button type="submit">Checkout</button>
        </form>

    </div>
</body>

</html>