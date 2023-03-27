<?php
// Include your database connection details here
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('Classes/Database.php');
$db = new Database("localhost", "root", "", "test");
$conn = $db->getConnection();
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$box_id = '';
$customer_id = '';

if (isset($_POST['submit'])) {
    $box_id = $_POST['box_id'];
    $customer_id = $_POST['customer_id'];

    $due_date_time = date('Y-m-d H:i:s', strtotime('+1 year'));
    $update_query = "UPDATE `box` SET `Due_Date_Time` = '$due_date_time' WHERE `ID` = '$box_id'";
    $update_result = mysqli_query($conn, $update_query);

    // Check if the update was successful
    if ($update_result) {
        // Display a success message
        echo '<script>alert("Payment successful!")</script>';
    } else {
        // Display an error message
        echo '<script>alert("Payment failed. Please try again.")</script>';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Make Payment</title>
</head>
<body>
    <h1>Make Payment</h1>
    <form method="POST">
        <label for="box_id">Box ID:</label>
        <input type="text" id="box_id" name="box_id" value="<?php echo $box_id; ?>"><br><br>
        <label for="customer_id">Customer ID:</label>
        <input type="text" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>"><br><br>
        <input type="submit" name="submit" value="Make Payment">
    </form>
</body>
</html>
