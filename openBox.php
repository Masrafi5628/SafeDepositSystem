<!DOCTYPE html>
<html>

<head>
    <title>Box Opening</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto|Sriracha&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="registration.css">
</head>

<body>
    <div class="container">
        <h1>Box Opening</h1>

        <?php

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

        // check if form is submitted
        $customer_id = $_SESSION['ID'];
        
        if (isset($_POST['submit'])) {
            $box_id = $_POST['box_id'];
            $customer_key = $_POST['customer_key'];
            $bank_key = $_POST['bank_key'];
            
            // check if box is available
            $check_box = "SELECT * FROM box WHERE ID = '$box_id' AND customer_key = '$customer_key' AND bank_key = '$bank_key'";
            $result = $conn->query($check_box);
            
            if ($result->num_rows > 0) {
                Session::set('box_id',$_POST['box_id']);
                // Insert a new row into the box_activity_log table
                $box_id = mysqli_real_escape_string($conn, $_POST['box_id']);
                $customer_id = mysqli_real_escape_string($conn, $customer_id);
                $current_time = date('Y-m-d H:i:s');
                $insert_query = "INSERT INTO box_activity_log (box_id, customer_id, check_in_time, check_out_time) VALUES ('$box_id', '$customer_id', '$current_time', NULL)";
                if ($conn->query($insert_query) === false) {
                    echo "Error: " . $insert_query . "<br>" . $conn->error;
                }
                // redirect to openedBox.php
                header("Location: openedBox.php?id=$box_id");
                exit();
            } else {
                echo "<script>alert('Sorry, the given information is not correct..!');</script>";

            }
        }

        // display form
        echo '<form method="post" action="">';
        echo '<label for="box_id">Box ID:</label>';
        echo '<select id="box_id" name="box_id">';
        $get_boxes = "SELECT * FROM test.box WHERE Customer_ID = '$customer_id'";
        $result = $conn->query($get_boxes);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo $row['ID'];
                echo $row['ID'];
                echo '<option value="' . $row['ID'] . '">' . $row['ID'] . '</option>';
            }
        }
        echo '</select><br>';
        echo '<br><label for="customer_key">Customer Key:</label>';
        echo '<input type="password" id="customer_key" name="customer_key" placeholder="****"><br>';
        echo '<label for="bank_key">Bank Key:</label>';
        echo '<input type="password" id="bank_key" name="bank_key" placeholder="****"><br>';
        echo '<input type="submit" name="submit" value="Submit">';
        echo '</form>';

        // close database connection
        $conn->close();
        ?>

    </div>
</body>

</html>