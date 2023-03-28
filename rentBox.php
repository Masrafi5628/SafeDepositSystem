<!DOCTYPE html>
<html>
<head>
    <title>Box Rental</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="registration.css">
</head>
<body>
    <div class="container">
        <h1>Box Rental</h1>

        <?php

        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);

        require_once('Classes/Database.php');
        $db = new Database("localhost", "root", "", "test");
        $conn = $db->getConnection();
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // check if form is submitted
        if (isset($_POST['submit'])) {
            $customer_id = $_POST['customer_id'];
            $box_size = $_POST['box_size'];

            // check if box is available
            $check_box = "SELECT * FROM box WHERE size = '$box_size' AND customer_id IS NULL";
            $result = $conn->query($check_box);

            if ($result->num_rows > 0) {
                // assign box to customer
                $row = $result->fetch_assoc();
                $box_id = $row['ID'];
                $rent_date_time = date('Y-m-d H:i:s');
                $due_date_time = date('Y-m-d H:i:s', strtotime('+365 days'));
                $update_box = "UPDATE box SET customer_id = '$customer_id', rent_date_time = '$rent_date_time', due_date_time = '$due_date_time' WHERE id = '$box_id'";
                $conn->query($update_box);

                // display box information
                echo "<div class='box-info' style='color:red'>";
                echo "<p>Box ID: " . $row['ID'] . "</p>";
                echo "<p>Box Size: " . $row['size'] . "</p>";
                echo "<p>Due Amount: $" . $row['Due_Amount'] . "</p>";
                echo "</div>";

            } else {
                echo "<p>Sorry, the selected box size is not available.</p>";
            }
        }

        // display form
        echo '<form method="post" action="">';
        echo '<label for="customer_id">Customer ID:</label>';
        echo '<input type="text" id="customer_id" name="customer_id"><br>';
        echo '<label for="box_size">Box Size:</label>';
        echo '<select id="box_size" name="box_size">';
        $get_sizes = "SELECT DISTINCT size FROM box WHERE Customer_ID IS NULL";
        $sizes_result = $conn->query($get_sizes);
        if ($sizes_result->num_rows > 0) {
            while ($size_row = $sizes_result->fetch_assoc()) {
                echo '<option value="' . $size_row['size'] . '">' . $size_row['size'] . '</option>';
            }
        }
        echo '</select><br>';
        echo '<input type="submit" name="submit" value="Submit">';
        echo '</form>';

        // close database connection
        $conn->close();
        ?>

    </div>
</body>
</html>
